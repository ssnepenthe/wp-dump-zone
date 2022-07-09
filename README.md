# wp-dump-zone

WP Dump Zone provides a simple approach to an improved experience of working the Symfony var-dumper component on a WordPress site.

Typically dumps are rendered at call time and, depending on the way a theme is styled, can lead to output that is difficult to read or interact with.

WP Dump Zone solves this problem by aggregating dump calls to be rendered after the rest of the page in a dedicated dump zone.

## Warning

This package is currently in development and is subject to breaking changes without notice until v1.0 has been tagged.

It is one in a series of [WordPress toys](https://github.com/ssnepenthe?tab=repositories&q=topic%3Atoy+topic%3Awordpress&type=&language=&sort=) I have been working on with the intention of exploring ways to modernize the feel of working with WordPress.

As the label suggests, it should be treated as a toy.

## Installation

```sh
composer require ssnepenthe/wp-dump-zone
```

## Usage

Replace calls to the `dump()` function with calls to the `dz()` function. That's it!

## Advanced Usage

The underlying cloner and dumper instances can be overridden using the corresponding setters: `DumpZone\DumpZone::setCloner()` and `DumpZone\DumpZone::setDumper()`.

By default, the dump zone is rendered in the `wp_footer` hook at a priority of `999`. These values can also be changed using the corresponding setters: `DumpZone\DumpZone::setRenderHook()` and `DumpZone\DumpZone::setRenderHookPriority()`.
