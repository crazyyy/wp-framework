=== ACF Theme Code Pro ===
Contributors: aaronrutley, ben-pearson
Requires at least: 4.8.0
Tested up to: 5.4.0
Stable tag: 2.5.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

ACF Theme Code will automatically generate the code needed to implement Advanced Custom Fields in your themes!

== Changelog ==

= 2.5.0 =
* Improve support for WordPress 5.4.
* Improve support for all field types included in ACF PRO 5.8.9 (including all their various settings).
* Improve codebase by syncing both free and pro foundations to facilitate faster development cycles and future features.
* Add escaping to code rendered to bring it in line with recent updates to ACF field documentation. See https://twitter.com/wp_acf/status/1181344882775875584.
* Improve code rendered for Taxonomy location.
* Add support for Current User, Current User Role, User Role locations.
* Add various enhancements to code rendered for the following fields and field settings:
  * Gallery field (return types Array, URL and ID)
  * Image (return types Array, URL and ID)
  * File (return types Array, URL and ID)
  * Select (values Single and Multiple, return types Value, Label and Array)
  * Checkbox (return types Value, Label and Array)
  * Radio Button (return type Array)
  * Button Group (return type Array)
  * True / False
  * Link (return types Array and URL)
  * Post Object (values Single and Multiple, return types Post Object and Post ID)
  * Page Link (values Single and Multiple)
  * Relationship (return types Post Object and Post ID)
  * Taxonomy (appearances Checkbox, Multi Select, Radio Buttons and Select, return types Term Object and Term ID)
  * User (values Single and Multiple, return types User Array, User Object and User ID)
  * Google Map
* Fixed issue with 'Copy All' fields functionality.

= 2.4.0 =
* Core: Theme Code Pro generates code to register for ACF Blocks and Options!
* Core: Theme Code Pro generates code for use within for ACF Blocks!
* Core: Radio Button field (core): Add support for all return types
* Core: Refactoring that will allow for the more options for the code generated in the future
* New Field Supported: ACF Icon Field
* New Field Supported: ACF Star Rating Field
* New Field Supported: ACF Color Palette Field 
* New Field Supported: ACF Image Aspect Ratio Crop
* New Field Supported: ACF Color Swatches
* New Field Supported: ACF SVG Icon

= 2.3.0 =
* New Field Supported: ACF Ninja Forms add on
* New Field Supported: ACF Gravity Forms add on
* New Field Supported: ACF RGBA Colour picker
* New Field(s) Supported: ACF qTranslate
* Core: Resolved EDD Conflicts
* Core: Improved Widget Location Variables
* Fix: EDD naming conflict
* Fix: Location error if visual editor is disabled
* Fix: Select Conflict with Seamless Field Group Option

= 2.2.0 =
* New Field Supported: Button Field found in ACF Pro v5.6.3
* New Field Supported: Range Field found in ACF Pro v5.6.2
* Core: Copy All Feature Added

= 2.1.0 =
* New Field Supported: Group Field found in ACF Pro v5.6
* New Field Supported: Link Field found in ACF Pro v5.6
* New Field Supported: Range Field (Third Party)
* New Field Supported: Focal Point Field (Third Party)
* Field: Code field improved to escape output by default
* Field: Google Map field improved to return address, lat & lng
* Core: resolved an issue with legacy PHP versions
* Fix: Bug in File field PHP when returned as a URL

= 2.0.0 =
* Core : Theme Code Pro now generates code based on your location rules!
* Core : Theme Code Pro now supports all official ACF Add ons!
* Core : Theme Code Pro now works when ACF Pro is included in a theme!
* Location Supported : Options Page
* Location Supported : Widget
* Location Supported : Comment
* Location Supported : Taxonomy Term
* Location Supported : User
* Location Supported : Attachment
* Add-on supported : Options Page
* Add on supported : Repeater Field
* Add on supported : Gallery Field
* Add on supported : Flexible Content Field
* Fix : Minor bug in file field example link markup
* Fix : Support for Quicklinks feature within locations

= 1.2.0 =
* Field: Clone - major improvements to the clone field code output
* New Field Supported: Address Field
* New Field Supported: Number Slider Field
* New Field Supported: Post Type Select Field
* New Field Supported: Code Field
* New Field Supported: Link Field
* New Field Supported: Link Picker Field
* New Field Supported: YouTube Picker Field
* Core: Special characters now removed from variable names
* Fix: Compatibility with CPTUI Pro Plugin

= 1.1.0 =
* Core: Quicklinks feature with anchor links to the relevant theme code block
* Core: Notice updates & various bug fixes
* Core: Plugin options screen moved under Settings

= 1.0.3 =
* Fix: Use the_sub_field method for nested File fields with return format URL

= 1.0.2 =
* Field: Fix for Post Object when using ACF 4
* Core: Various internal code improvements

= 1.0.1 =
* Field: Checkbox updated to support array
* Field: Select updated to support array

= 1.0.0 =
* First version
