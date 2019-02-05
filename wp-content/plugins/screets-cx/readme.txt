=== Screets Live Chat X ===
Tags: chat, live chat, help desk, contact, support
Requires at least: 4.7
Tested up to: 4.9.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Screets Live Chat is a powerful chat plugin for WordPress. It allows you to speak/chat directly with your visitors on your website.

== Description ==

A powerful tool for chatting with your visitors on your HTML, PHP or WordPress website.

= Credits =

* Icons: Ionicons - http://ionicons.com

== Installation ==

1. Upload the zip package directory to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress

== Changelog ==

Legend:
    (+) new feature/improvement,  (*) functionality changes, (!) bugfix

    Version 2.6.1 - 22 March 2018
        +   Multilingual compatibility (WPML and Polylang plugins)
        +   Added "custom css" box in design options directly for chat widget.
        !   Fixed unexpected popup view in front-end
        !   Fixed offline form sending issue faced in some WP installations

    Version 2.6.0 - 15 March 2018
        +   Better UI for chat box and starter
        +   Working in iframe (improves your page load performance)
        +   Offline form
        +   Show online operators (when online) and recently active operators (when no operator is online)
        +   Now set both horizontal & vertical offsets separately
        +   Visitors can "end chat"
        +   Visitors can vote ended chat (solved / unsolved)
        +   New chat sounds for visitors
        +   Operators see visitors current page url without local domain. It is more clean now (i.e. "https://yourdomain.com/about" will be changed with "/about")
        *   Chats list performance is improved
        *   Go to conversations when a chat deleted automatically
        *   Updated phpscss into 0.7.4
        *   A chat will be unarchived if visitor sends new message
        !   Fixed unsupported URL in file_get_contents in some PHP servers
        !   Fixed saving options error in old PHP versions
        !   Fixed "chat console" link in top admin bar
        !   Fixed sending chat logs to wrong email while ending chat
        -   (removed) Pre-chat box
    
    Version 2.5.2 - 13 February 2018
        !   Fixed saving options in ancient PHP versions 5.4 and newer

    Version 2.5.1 - 31 January 2018
        *   Updated console.css file
        !   Fixed some installation conflicts on real-time database (i.e. resetting case number issue)
    
    Version 2.5.0 - 31 January 2018
        +   Archive chat
        +   Delete chat
        +   Re-join chat when its closed
        +   Online/offline buttons for operators
        +   Now you can set response times by online/offline status
        +   Shows recently active operators to visitors
        +   Edit basic visitor profile info (name, email, etc.)
        +   Convert plain URLs into clickable links in chat messages
        *   Improved compatibility with WP themes & plugins
        -   (Deprecated) Pre-chat height option (now it's calculated automatically).
        
    Version 2.4.0 [Major update] - 23 January 2018
        +   New UI design
        +   Better user authentication
        +   Multiple conversation
        +   Random visitor names
        +   Case numbers
        +   Email transcripts
        *   Updated Firebase into 4.8.2