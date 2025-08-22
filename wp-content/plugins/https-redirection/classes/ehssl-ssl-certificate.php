<?php
class EHSSL_SSL_Certificate
{

    public function __construct()
    {

    }

    public function handle_ssl_installation($email, $live_mode = false)
    {
        global $httpsrdrctn_options;

        EHSSL_Logger::log("Starting SSL certificate generation process...");
        $well_known_dir_path = ABSPATH . ".well-known";
        $acme_challenge_dir_path = $well_known_dir_path . "/acme-challenge";
        $certificate_dir_path = $well_known_dir_path . "/certificate";
        $upload_dir = wp_upload_dir();

        EHSSL_Logger::log("Creating directories for acme-challenge & certificate files");
        EHSSL_Logger::log("Certificate Directory: " . $certificate_dir_path);
        EHSSL_Logger::log("Acme-Challenge Directory: " . $acme_challenge_dir_path);
        $certificate_directories = $this->create_directories($acme_challenge_dir_path, $certificate_dir_path);
        if (is_wp_error($certificate_directories)) {
            return $certificate_directories;
        }

        // Instantiate the YAAC client.
        // Save account keys in .well-kown/account.
        $adapter = new League\Flysystem\Local\LocalFilesystemAdapter($well_known_dir_path . "/account");
        $filesystem = new League\Flysystem\Filesystem($adapter);

        $mode = $live_mode ? Afosto\Acme\Client::MODE_LIVE : Afosto\Acme\Client::MODE_STAGING;
        EHSSL_Logger::log("Initiating Certificate Request for " . strtoupper($mode) . " Mode.");

        $client = new Afosto\Acme\Client([
            'username' => $email,
            'fs'       => $filesystem,
            'mode'     => $mode,
        ]);

        try {
            $domains = array();
            $domain = EHSSL_Utils::get_domain();
            $domain_variant = EHSSL_Utils::get_domain_variant($domain);

            $domains[] = $domain;

            // Check if domain variant is accessible.
            if (EHSSL_Utils::is_domain_accessible($domain_variant)) {
                $domains[] = $domain_variant;
            }

            EHSSL_Logger::log("Domains to get certificate for: " . implode(",", $domains));

            $order = $client->createOrder($domains);
            EHSSL_Logger::log("Creating order for Lets Encrypt");

            // Prove ownership (HTTP or DNS validation).
            $authorizations = $client->authorize($order);
            EHSSL_Logger::log("Prove ownership (HTTP or DNS validation)");

            // Saving authorizations & performing Self tests.
            EHSSL_Logger::log("Saving authorizations & performing Self tests");
            foreach ($authorizations as $authorization) {
                $file = $authorization->getFile();
                file_put_contents($acme_challenge_dir_path . "/" . $file->getFilename(), $file->getContents());

                // Self-test.
                // After exposing the challenges (made accessible through HTTP or DNS) we should perform a self test just to be sure it works before asking Let's Encrypt to validate ownership.
                if (!$client->selfTest($authorization, Afosto\Acme\Client::VALIDATION_HTTP)) {
                    EHSSL_Logger::log("Could not verify ownership via HTTP");
                    throw new \Exception(__('Could not verify ownership via HTTP', 'https-redirection'));
                }
            }

            // Request validation.
            EHSSL_Logger::log("Request validation");
            foreach ($authorizations as $authorization) {
                $client->validate($authorization->getHttpChallenge(), 15);
            }

            if ($client->isReady($order)) {
                // The validation was successful.
                EHSSL_Logger::log("The validation was successful.");
                $certificate = $client->getCertificate($order);

                EHSSL_Logger::log("Saving certificates in certificate directory.");
                file_put_contents($certificate_dir_path . '/certificate.crt', $certificate->getCertificate());
                file_put_contents($certificate_dir_path . '/cabundle.crt', $certificate->getIntermediate());
                file_put_contents($certificate_dir_path . '/private.pem', $certificate->getPrivateKey());
                file_put_contents($certificate_dir_path . '/certificate_expiry.txt', $certificate->getExpiryDate()->format('Y-m-d H:i:s'));

                // Updating certificate expiry date.
                EHSSL_Logger::log("Updating certificate expirty date in db.");

                $httpsrdrctn_options['ehssl_expiry_ssl_certificate'] = $certificate->getExpiryDate()->format('Y-m-d H:i:s');
                update_option('httpsrdrctn_options', $httpsrdrctn_options);

                EHSSL_Logger::log("Certificate saved successfully");
                return 'SSL Certificate generated successfully! Download certificate now. Certificate will expire on: ' . $certificate->getExpiryDate()->format('Y-m-d H:i:s');
            }
            EHSSL_Logger::log("SSL Certificate installation failed.");
            return new WP_Error("1003", __("SSL Certificate installation failed. Check the logs for details.", 'https-redirection'));
        } catch (Exception $ex) {
            EHSSL_Logger::log("Exception Raised:" . $ex->getMessage());
            return new WP_Error("1004", $ex->getMessage());
        }
    }


    public static function get_certificate_urls()
    {
        $well_known_dir_path = ABSPATH . '.well-known';
        $certificate_dir_path = $well_known_dir_path . "/certificate";

        $certificate_file = $certificate_dir_path . '/certificate.crt';
        $ca_bundle = $certificate_dir_path . '/cabundle.crt';
        $private_key_file = $certificate_dir_path . '/private.pem';
        $certificate_expiry_file = $certificate_dir_path . '/certificate_expiry.txt';

        // Check if the certificate and private key files exist.
        if (!file_exists($certificate_file) || !file_exists($private_key_file) || !file_exists($ca_bundle) || !file_exists($certificate_expiry_file)) {
            return new WP_Error('file_not_found', __('Certificate or private key file not found. Please generate a certificate first!', 'https-redirection'));
        }

        // Convert file system paths to URLs.
        // $well_known_dir_path = realpath('.well-known');
        $well_known_dir_url = site_url('.well-known');
        $certificate_dir_url = $well_known_dir_url . '/certificate';

        return array(
            "certificate.crt" => array(
                'path' => realpath($certificate_file),
                'url' => $certificate_dir_url . '/certificate.crt',
            ),
            "cabundle.crt" => array(
                'path' => realpath($ca_bundle),
                'url' => $certificate_dir_url . '/cabundle.crt',
            ),
            "private.pem" => array(
                'path' => realpath($private_key_file),
                'url' => $certificate_dir_url . '/private.pem',
            )
        );
    }


    private function create_directories($acme_challenge_dir_path, $certificate_dir_path)
    {
        // Check and create the acme-challenge directory if it doesn't exist.
        if (!is_dir($acme_challenge_dir_path)) {
            if (!mkdir($acme_challenge_dir_path, 0755, true)) {
                EHSSL_Logger::log("Failed to create the acme-challenge directory");
                return new WP_Error("1001", __("Failed to create the acme-challenge directory", 'https-redirection'));
            }
        }

        if (!is_dir($certificate_dir_path)) {
            if (!mkdir($certificate_dir_path, 0755, true)) {
                EHSSL_Logger::log("Failed to create the certificate directory");
                return new WP_Error("1002", __("Failed to create the certificate directory", 'https-redirection'));
            }
        }

        return true;
    }
}