# Backup component

[![Build Status](https://travis-ci.org/devhelp/Backup.svg?branch=master)](https://travis-ci.org/devhelp/Backup)
[![Coverage Status](https://coveralls.io/repos/devhelp/Backup/badge.png)](https://coveralls.io/r/devhelp/Backup)

## Purpose

This component provides backup functionality. It uses `Flysystem` component.

## Instalation

```composer require 'devhelp/backup:dev-master'```

## Usage

```php
    
    use League\Flysystem\Filesystem;
    use League\Flysystem\Adapter\Ftp as FtpAdapter;
    use League\Flysystem\Adapter\Local as LocalAdapter;
    use Devhelp\Component\Backup\Backup;
    use Devhelp\Component\Backup\Provider\FilesystemAdapterProvider;
    use Devhelp\Component\Backup\Strategy\FileBackupStrategy;


    $ftp = new Filesystem(new FtpAdapter(array(
        'host' => 'example.com',
        'username' => 'ftp_user',
        'password' => 'ftp_password',
        'port' => 21,
        'root' => '/',
        'passive' => true,
        'ssl' => true,
        'timeout' => 30,
    )));
    
    $listStrategy = new FileListBackupStrategy();
    $listStrategy->setRemoteAdapter($ftp);
    
    $local = new Filesystem(new LocalAdapter($dir));
    $adapterProvider = new FilesystemAdapterProvider($ftp, $local);
    
    $backup = new Backup($adapterProvider, $listStrategy);
    $backup->runBackup();
```