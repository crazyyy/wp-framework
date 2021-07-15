<?php
if( ! class_exists('pbcockpitnotice') ):
    class pbcockpitnotice
    {
        var $version                    = '20200216';

        var $transient_name             = 'cockpit_notice';
        var $transient_closed_val       = 'closed';
        var $allowed_screens            = array();
        var $only_on_screens            = false;
        var $close_on_screens           = false;
        var $logo                       = false;
        var $link_de                    = 'https://cockpit.bajorat-media.com/infos/';
        var $link_en                    = 'https://cockpit.bajorat-media.com/en/infos/';

        public function __construct( $config = array() )
        {
            $config                     = apply_filters('pbcockpitnotice_config', $config);

            if( isset($config['logo']) && !empty($config['logo']) ) {
                $this->logo             = $config['logo'];
            }

            if( isset($config['allowed_screens']) && !empty($config['allowed_screens']) ) {
                $this->allowed_screens  = $config['allowed_screens'];
            }

            if( isset($config['only_on_screens']) && !empty($config['only_on_screens']) ) {
                $this->only_on_screens  = $config['only_on_screens'];
            }

            if( isset($config['close_on_screens']) && !empty($config['close_on_screens']) ) {
                $this->close_on_screens = $config['close_on_screens'];
            }

            if( isset($config['link_de']) && !empty($config['link_de']) ) {
                $this->link_de          = $config['link_de'];
            }

            if( isset($config['link_en']) && !empty($config['link_en']) ) {
                $this->link_en          = $config['link_en'];
            }

            if( is_user_logged_in() && is_admin() ) {
                $this->transient_name = apply_filters('pbcockpitnotice_transient_name', $this->transient_name);

                add_action('admin_init', [$this, 'close']);
                add_action('admin_notices', [$this, 'notice']);
            }
        }

        public function notice()
        {
            global $pbcockpitnotice_duplicate_check;

            $screen                 = get_current_screen();
            $closed_transient       = get_option($this->transient_name, false);

            if( ! $closed_transient ) {
                $closed_transient   = get_transient($this->transient_name);
            }

            if( $pbcockpitnotice_duplicate_check === true ) return;

            if( $closed_transient == $this->transient_closed_val &&
                ( is_object($screen) && ! in_array($screen->id, $this->allowed_screens) ) ) return;

            if( $this->only_on_screens &&
                ( is_object($screen) && ! in_array($screen->id, $this->allowed_screens) ) ) return;

            if( $this->close_on_screens &&
                $closed_transient == $this->transient_closed_val ) return;

            if (get_locale() == 'de_DE_formal' || get_locale() == 'de_DE') {
                $link = $this->link_de;
            } else {
                $link =  $this->link_en;
            }

            $pbcockpitnotice_duplicate_check = true;
            ?>
            <style type="text/css">

                @import url('https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap');

                .bmcockpit-container {
                    margin: 0 auto;
                    box-sizing: border-box;
                    width: 100%;
                    padding: 45px 10px 5px 0;
                }
                <?php
                foreach( $this->allowed_screens as $screen_id ) {
                    echo '.'.$screen_id.' .bmcockpit-container { padding: 20px 20px 10px 0; }';
                }
                ?>

                .bmlogo {
                    padding:0;
                    border-radius:0;
                    position:absolute;
                    z-index:2;
                    top:50%;
                    left:30px;
                    transform: translate(0, -50%);
                    line-height:1;
                    outline: 0;
                }
                .bmcockpit-banner {
                    font-family: 'Roboto', sans-serif;
                    background: #0668b6;
                    background: -moz-linear-gradient(left, #0668b6 0%, #01b1cf 100%);
                    background: -webkit-linear-gradient(left, #0668b6 0%, #01b1cf 100%);
                    background: linear-gradient(to right, #0668b6 0%, #01b1cf 100%);
                    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#0668b6', endColorstr='#01b1cf',GradientType=1 );
                    color: #fff;
                    padding: 20px 250px 20px 280px;
                    position: relative;
                    overflow:hidden;
                    box-sizing: border-box;
                }
                .bmcockpit-banner:before {
                    position:absolute;
                    content:'';
                    top:0;
                    left:200px;
                    width: 0;
                    height: 0;
                    border-style: solid;
                    border-width: 180px 0 0 100px;
                    border-color: transparent transparent transparent #fff;
                    z-index:1;
                }
                @media (max-width: 1470px) {
                    .bmcockpit-banner:before {
                        border-width: 230px 0 0 100px;
                    }
                }
                .bmcockpit-banner:after {
                    position:absolute;
                    top:0;
                    left:0;
                    content:'';
                    height:100%;
                    width:100%;
                    max-width:200px;
                    z-index:1;
                    background:#fff;
                }
                @media (max-width: 1200px) {
                    .bmcockpit-banner {
                        padding: 80px 30px 20px 30px;
                        text-align:center;
                        width:100%;
                    }
                }
                .bmcockpit-banner a.bmbtn {
                    background: #fff;
                    display: inline-block;
                    padding: 10px 20px;
                    border-radius: 30px;
                    color: #01b1cf !important;
                    border: none;
                    font-size:18px;
                    font-weight: 600;
                    cursor: pointer;
                    width: auto;
                    outline: none;
                    text-decoration: none;
                    transition: 0.3s ease-in-out all;
                    position: absolute;
                    top: 50%;
                    right: 40px;
                    transform: translate(0, -50%);
                    animation: pulse 2s infinite;
                }
                @media (max-width: 1200px) {
                    .bmcockpit-banner a.bmbtn {
                        position: static;
                        margin-top: 10px;
                        transform: none; }
                }
                .bmcockpit-banner a.bmbtn:hover {
                    /*animation: pulse 2s 1;*/
                    background: rgba(255, 255, 255, 0.9) !important; }
                @-webkit-keyframes pulse {
                    0% {
                        -webkit-box-shadow: 0 0 0 0 rgba(0, 255, 255, 0.7); }
                    70% {
                        -webkit-box-shadow: 0 0 0 10px rgba(0, 255, 255, 0); }
                    100% {
                        -webkit-box-shadow: 0 0 0 0 rgba(0, 255, 255, 0); } }
                @keyframes pulse {
                    0% {
                        -moz-box-shadow: 0 0 0 0 rgba(0, 255, 255, 0.7);
                        box-shadow: 0 0 0 0 rgba(0, 255, 255, 0.7); }
                    70% {
                        -moz-box-shadow: 0 0 0 10px rgba(0, 255, 255, 0);
                        box-shadow: 0 0 0 10px rgba(0, 255, 255, 0); }
                    100% {
                        -moz-box-shadow: 0 0 0 0 rgba(0, 255, 255, 0);
                        box-shadow: 0 0 0 0 rgba(0, 255, 255, 0); } }
                .bmcockpit-banner h1,
                .bmcockpit-banner p,
                .bmcockpit-banner ul {
                    color: #fff;
                    margin: 0;
                    padding: 0;
                    font-size: 16px;
                    font-weight: 300; }
                .bmcockpit-banner h1 {
                    font-size: 25px;
                    margin-bottom: 10px;
                    line-height: 1.2;
                    font-weight: 300; }

                @media (max-width: 1600px) {
                    .bmcockpit-banner h1 {
                        font-size: 20px;}
                }

                .bmcockpit-banner ul.bmcockpit-benefits {
                    list-style: none;
                    margin-top: 0!important;
                    display: block; }
                .bmcockpit-banner ul.bmcockpit-benefits li {
                    margin: 10px 15px 5px 0;
                    display: inline-block; }
                .bmcockpit-banner ul.bmcockpit-benefits li:before {
                    content: '\2713';
                    padding: 0 5px;
                    color: #01b1cf;
                    margin-right: 5px;
                    display: inline-block;
                    background: #fff;
                    border-radius: 100px; }
                .bmcockpit-banner .bmcockpit-banner-close {
                    position:absolute;
                    top:0;
                    right:0;
                    background:rgba(255,255,255,0.2);
                    color:#fff!important;
                    font-size:16px;
                    border-radius:0;
                    animation:none!important;
                    padding:5px 10px;
                    transform:none;
                    z-index:5;
                    text-decoration:none;
                }
                .bmcockpit-banner .bmcockpit-banner-close:hover {
                    color:#0668b6!important;
                }
                @media (max-width: 1200px) {
                    .bmcockpit-banner:before {
                        display:none;
                    }
                    .bmcockpit-banner:after {
                        content:'';
                        height:60px;
                        width:100%;
                        max-width:100%;
                    }
                    .bmcockpit-banner .bmlogo {
                        top:10px;
                        left:50%;
                        transform: translate(-50%, 0);
                    }
                    .bmcockpit-banner .bmcockpit-banner-close {
                        color:#0668b6!important;
                    }
                    .bmbtn-container {
                        text-align:center;
                    }
                }

            </style>
            <div class="bmcockpit-container">
                <div class="bmcockpit-banner">
                    <?php if( ( is_object($screen) && ! in_array($screen->id, $this->allowed_screens) ) || $this->close_on_screens ): ?>
                        <a class="bmcockpit-banner-close" href="<?php echo esc_url( admin_url('/?cockpit_notice=close') ); ?>">&#215;</a>
                    <?php endif; ?>

                    <a href="<?php echo esc_url($link); ?>" class="bmlogo" target="_blank">
                        <?php if( ! empty($this->logo) ): ?>
                            <img width="170" height="39" src="<?php echo esc_url($this->logo) ?>" alt="Bajorat Media" />
                        <?php endif; ?>
                    </a>

                    <?php if (get_locale() == 'de_DE_formal' || get_locale() == 'de_DE'): ?>
                        <h1>Design &amp; Entwicklungsleistungen rund um WordPress!</h1>
                        <ul class="bmcockpit-benefits">
                            <li>Kostenlose Projektanfrage</li>
                            <li>Schnelle Reaktionszeiten</li>
                            <li>Erfahrenes Team</li>
                            <li>OnDemand-Service</li>
                        </ul>

                        <div class="bmbtn-container">
                            <a class="bmbtn" href="<?php echo esc_url($link); ?>" target="_blank">Jetzt mehr erfahren!</a>
                        </div>
                    <?php else: ?>
                        <h1>Design &amp; development services for WordPress, try our on-demand service portal</h1>
                        <ul class="bmcockpit-benefits">
                            <li>free estimates</li>
                            <li>fast response times</li>
                            <li>experienced team</li>
                            <li>top service</li>
                        </ul>

                        <div class="bmbtn-container">
                            <a class="bmbtn" href="<?php echo esc_url($link); ?>" target="_blank">Find out more now!</a>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
            <?php
        }

        public function close()
        {
            if( isset($_GET['cockpit_notice']) && $_GET['cockpit_notice'] == 'close' ) {
                update_option($this->transient_name, $this->transient_closed_val);
            }
        }
    }
endif;