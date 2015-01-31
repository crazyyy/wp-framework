=== Antispam Bee ===
Contributors: sergej.mueller
Tags: antispam, spam, comments, trackback
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=5RDDW9FEHGLG6
Requires at least: 3.8
Tested up to: 3.8
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html



Say Goodbye zu Spam in deinem Blog. Kostenlos, werbefrei und datenschutzkonform. Für Kommentare und Trackbacks.



== Description ==

Blog-Spam bekämpfen ist die Stärke von *Antispam Bee*. Seit Jahren wird das Plugin darauf trainiert, Spam-Kommentare zuverlässig zu erkennen (auf Wunsch auch sofort zu beseitigen). Dabei greift *Antispam Bee* auf unterschiedliche Techniken zu, die sich zur Identifizierung von Spam-Nachrichten bewährt haben.


= Pluspunkte =
* Aktive Weiterentwicklung seit 2009
* Über 20 untereinander kombinierbare Funktionen
* Keine Speicherung von personenbezogenen Daten
* Volle Transparenz bei der Prüfung der Kommentare
* Keine Registrierung notwendig
* Kostenlos auch für kommerzielle Projekte
* Keine Anpassung von Theme-Templates vonnöten
* Alle Funktionen vom Nutzer steuerbar
* Statistik der letzten 30 Tage als Dashboard-Widget


= Einstellungen =
Nach der Aktivierung nimmt *Antispam Bee* den regulären Betrieb auf, indem vordefinierte Schutzmechanismen scharf geschaltet werden. Es empfiehlt sich jedoch, die Seite mit Plugin-Einstellungen aufzurufen und sich mit wirkungsvollen Optionen auseinander zu setzen. Alle Optionsschalter sind in der [Online-Dokumentation](http://playground.ebiene.de/antispam-bee-wordpress-plugin/) detailliert vorgestellt.

Die meisten Auswahlmöglichkeiten innerhalb der Optionsseite sind konfigurierbare Antispam-Filter, die der Blog-Administrator nach Bedarf aktiviert. Zahlreiche Wahlmöglichkeiten steuern hingegen die Benachrichtigungs- und die automatische Löschfunktion des Plugins. Die *Antispam Bee* Optionen in der Kurzfassung:

* Genehmigten Kommentatoren vertrauen
* BBCode als Spam einstufen
* IP-Adresse des Kommentators validieren
* Reguläre Ausdrücke anwenden
* Lokale Spamdatenbank einbeziehen
* Öffentliche Spamdatenbank berücksichtigen
* Bestimmte Länder blockieren bzw. erlauben
* Kommentare nur in einer Sprache zulassen
* Erkannten Spam kennzeichnen, nicht löschen
* Bei Spam via E-Mail informieren
* Optionale Logdatei mit Spam-Einträgen z.B. für [Fail2Ban](http://cup.wpcoder.de/fail2ban-ip-firewall/)
* Spamgrund im Kommentar nicht speichern
* Vorhandenen Spam nach X Tagen löschen
* Aufbewahrung der Spam-Kommentare für einen Typ
* Bei definierten Spamgründen sofort löschen
* Statistiken als Dashboard-Widget generieren
* Spam-Anzahl auf dem Dashboard anzeigen
* Eingehende Ping- und Trackbacks ignorieren
* Kommentarformular befindet sich auf Archivseiten


= Datenschutz =
In Blogs innerhalb der EU-Länder darf die Option *"Öffentliche Spamdatenbank berücksichtigen"* nicht aktiviert werden, da das Antispam-Plugin ungekürzte IP-Adressen der Kommentatoren dafür verwendet, diese in der öffentlichen Spammer-Datenbank nachzuschlagen und als Spam zu identifizieren. Technisch ist die Verschlüsselung der IP nicht möglich, da Spammer-Datenbanken mit vollständigen, unverschlüsselten IP-Adressen arbeiten. [Weitere Details](http://playground.ebiene.de/antispam-bee-wordpress-plugin/#dnsbl_check)


= Schlusswort =
Installiert, probiert die bewährte Antispam-Lösung für WordPress aus.
Anmeldefrei und ohne lästige Captchas.


= Support =
Freundlich formulierte Fragen rund um das Plugin werden per E-Mail beantwortet.


= Systemanforderungen =
* PHP 5.2.4
* WordPress 3.8


= Inkompatibilität =
* Disqus
* Jetpack Comments
* AJAX-Kommentarformulare


= Unterstützung =
* Per [Flattr](https://flattr.com/t/1323822)
* Per [PayPal](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=5RDDW9FEHGLG6)


= Handbuch =
* [Antispam Bee: Antispam für WordPress](http://playground.ebiene.de/antispam-bee-wordpress-plugin/)


= Website =
* [antispambee.de](http://antispambee.de)


= Autor =
* [Twitter](https://twitter.com/wpSEO)
* [Google+](https://plus.google.com/110569673423509816572)
* [Plugins](http://wpcoder.de)





== Changelog ==

= 2.6.0 =
* DE: Optimierungen für WordPress 3.8
* DE: Zusatzprüfung auf Nicht-UTF-8-Zeichen in Kommentardaten
* DE: Spamgrund als Spalte in der Übersicht mit Spamkommentaren
* EN: Optimizations for WordPress 3.8
* EN: Clear invalid UTF-8 characters in comment fields
* EN: Spam reason as a column in the table with spam comments

= 2.5.9 =
* DE: Anpassung des Dashboard-Skriptes für die Zusammenarbeit mit [Statify](http://statify.de)
* EN: Dashboard widget changes to work with [Statify](http://statify.de)

= 2.5.8 =
* DE: Umstellung von TornevallDNSBL zu [Stop Forum Spam](http://www.stopforumspam.com)
* DE: Neue JS-Bibliothek für das Dashboard-Widget
* DE: [Mehr Informationen auf Google+](https://plus.google.com/110569673423509816572/posts/VCFr3fDAYDs)
* EN: Switch from TornevallDNSBL to [Stop Forum Spam](http://www.stopforumspam.com)
* EN: New JS library for the Antispam Bee dashboard chart

= 2.5.7 =
* DE: Optionale Spam-Logdatei z.B. für [Fail2Ban](http://cup.wpcoder.de/fail2ban-ip-firewall/)
* DE: Filter `antispam_bee_notification_subject` für eigenen Betreff in Benachrichtigungen
* DE: Detaillierte Informationen zum Update auf [Google+](https://plus.google.com/110569673423509816572/posts/iCfip2ggYt9)
* EN: Optional logfile with spam entries e.g. for [Fail2Ban](https://gist.github.com/sergejmueller/5622883)
* EN: Filter `antispam_bee_notification_subject` for a custom subject in notifications

= 2.5.6 =
* DE: Neue Erkennungsmuster für Spam hinzugefügt / [Google+](https://plus.google.com/110569673423509816572/posts/9BSURheN3as)
* EN: Added new detection/patterns for spam comments

= 2.5.5 =
* Deutsch: Erkennung und Ausfilterung von Spam-Kommentaren, die versuchen, [Sicherheitslücken von W3 Total Cache und WP Super Cache](http://blog.sucuri.net/2013/05/w3-total-cache-and-wp-super-cache-vulnerability-being-targeted-in-the-wild.html) auszunutzen. [Ausführlicher auf Google+](https://plus.google.com/110569673423509816572/posts/afWWQbUh4at).
* English: Detection and filtering of spam comments that try to exploit the latest [W3 Total Cache and WP Super Cache Vulnerability](http://blog.sucuri.net/2013/05/w3-total-cache-and-wp-super-cache-vulnerability-being-targeted-in-the-wild.html).

= 2.5.4 =
* Jubiläumsausgabe: [Details zum Update](https://plus.google.com/110569673423509816572/posts/3dq9Re5vTY5)
* Neues Maskottchen für Antispam Bee
* Erweiterte Prüfung eingehender Kommentare in lokaler Blog-Spamdatenbank auf IP, URL und E-Mail-Adresse

= 2.5.3 =
* Optimierung des Regulären Ausdrucks

= 2.5.2 =
* Neu: [Reguläre Ausdrücke anwenden](http://playground.ebiene.de/antispam-bee-wordpress-plugin/#regexp_check) mit vordefinierten und eigenen Erkennungsmustern
* Änderung der Filter-Reihenfolge
* Verbesserungen an der Sprachdatei
* [Hintergrundinformationen zum Update](https://plus.google.com/110569673423509816572/posts/CwtbSoMkGrT)

= 2.5.1 =
* [BBCode im Kommentar als Spamgrund](http://playground.ebiene.de/antispam-bee-wordpress-plugin/#bbcode_check)
* IP-Anonymisierung bei der Länderprüfung
* [Mehr Transparenz](https://plus.google.com/110569673423509816572/posts/ZMU6RfyRK29) durch hinzugefügte Datenschutzhinweise
* PHP 5.2.4 als Voraussetzung (ist zugleich die Voraussetzung für WP 3.4)

= 2.5.0 =
* [Edition 2012](https://plus.google.com/110569673423509816572/posts/6JUC6PHXd6A)

= 2.4.6 =
* Russische Übersetzung
* Veränderung der Secret-Zeichenfolge

= 2.4.5 =
* Überarbeitetes Layout der Einstellungen
* Streichung von Project Honey Pot
* TornevallNET als neuer DNSBL-Dienst
* WordPress 3.4 als Mindestvoraussetzung
* WordPress 3.5 Unterstützung
* Online-Handbuch in Neufassung

= 2.4.4 =
* Technical and visual support for WordPress 3.5
* Modification of the file structure: from `xyz.dev.css` to `xyz.min.css`
* Retina screenshot

= 2.4.3 =
* Check for basic requirements
* Remove the sidebar plugin icon
* Set the Google API calls to SSL
* Compatibility with WordPress 3.4
* Add retina plugin icon on options
* Depending on WordPress settings: anonymous comments allowed

= 2.4.2 =
* New geo ip location service (without the api key)
* Code cleanup: Replacement of `@` characters by a function
* JS-Fallback for missing jQuery UI

= 2.4.1 =
* Add russian translation
* Fix for the textarea replace
* Detect and hide admin notices

= 2.4 =
* Support for IPv6
* Source code revision
* Delete spam by reason
* Changing the user interface
* Requirements: PHP 5.1.2 and WordPress 3.3

= 2.3 =
* Xmas Edition

= 2.2 =
* Interactive Dashboard Stats

= 2.1 =
* Remove Google Translate API support

= 2.0 =
* Allow comments only in certain language (English/German)
* Consider comments which are already marked as spam
* Dashboard Stats: Change from canvas to image format
* System requirements: WordPress 2.8
* Removal of the migration script
* Increase plugin security

= 1.9 =
* Dashboard History Stats (HTML5 Canvas)

= 1.8 =
* Support for the new IPInfoDB API (including API Key)

= 1.7 =
* Black and whitelisting for specific countries
* "Project Honey Pot" as a optional spammer source
* Spam reason in the notification email
* Visual refresh of the notification email
* Advanced GUI changes + Fold-out options

= 1.6 =
* Support for WordPress 3.0
* System requirements: WordPress 2.7
* Code optimization

= 1.5 =
* Compatibility with WPtouch
* Add support for do_action
* Translation to Portuguese of Brazil

= 1.4 =
* Enable stricter inspection for incomming comments
* Do not check if the author has already commented and approved

= 1.3 =
* New code structure
* Email notifications about new spam comments
* Novel Algorithm: Advanced spam checking

= 1.2 =
* Antispam Bee spam counter on dashboard

= 1.1 =
* Adds support for WordPress new changelog readme.txt standard
* Various changes for more speed, usability and security

= 1.0 =
* Adds WordPress 2.8 support

= 0.9 =
* Mark as spam only comments or only pings

= 0.8 =
* Optical adjustments of the settings page
* Translation for Simplified Chinese, Spanish and Catalan

= 0.7 =
* Spam folder cleanup after X days
* Optional hide the &quot;MARKED AS SPAM&quot; note
* Language support for Italian and Turkish

= 0.6 =
* Language support for English, German, Russian

= 0.5 =
* Workaround for empty comments

= 0.4 =
* Option for trackback and pingback protection

= 0.3 =
* Trackback and Pingback spam protection



== Screenshots ==

1. Antispam Bee Optionen