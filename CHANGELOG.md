# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [0.2.0] - 2026-05-28

### Added
- Complete set of 22 dedicated REST-native **Service Managers** using clean HTTP verbs (`GET`, `PUT`, `POST`, `DELETE`, `PATCH`).
- Fluent **REST Query Builder** supporting conditional chaining (`where`, `select`, `get`) translated directly to REST URL parameters.
- Dual-Stack IPv4 / IPv6 REST native endpoints for network, firewall, and route management.
- `RouterPingCommand` Artisan tool `mivo:ros7-ping` using native REST GET for active diagnostics.

## [0.1.0] - 2026-05-26

### Added
- `MikrotikManager` implementing a Hybrid Connection approach for dynamic, multi-tenant router management.
- `MikrotikRos7ServiceProvider` for Laravel auto-discovery and config binding.
- `MikrotikRos7` Facade for easy global access to the API client or Manager.
- Published configuration file `mikrotik-ros7.php` with defaults mapping to `.env` variables.
