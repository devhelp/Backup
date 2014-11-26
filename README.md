# Backup component

[![Build Status](https://travis-ci.org/devhelp/Backup.svg?branch=master)](https://travis-ci.org/devhelp/Backup)
[![Coverage Status](https://coveralls.io/repos/devhelp/Backup/badge.png?branch=master)](https://coveralls.io/r/devhelp/Backup?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/devhelp/Backup/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/devhelp/Backup/?branch=master)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/1df16392-260e-4f42-adfc-f5ac2af4f449/mini.png)](https://insight.sensiolabs.com/projects/1df16392-260e-4f42-adfc-f5ac2af4f449)

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
