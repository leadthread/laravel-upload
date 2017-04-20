# Changelog

All notable changes to `laravel-upload` will be documented in this file.

### 2.0.0
- Changed ownership from zenapply to leadthread
- Namespace changes

### 1.1.0
- Can now toggle file hash checking and also change the hashing algorithm.

### 1.0.3
- Fix tests for Laravel 5.2

### 1.0.2
- Fixed Laravel 5.3 bug with migrations

### 1.0.1
- Fixed return the same DB entry for a duplicate file instead of creating a new one

### 1.0.0
- Using this in production now.
- Added a storage saving method by only writing the file to the disk if it has a unique MD5.

### 0.0.2
- Fixed tests.
- Automatically saves model to DB.

### 0.0.1
- Initial release and connected with packagist.
