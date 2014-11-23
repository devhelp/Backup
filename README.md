# Backup component

## Purpose

This component provides backup functionality. It uses `Flysystem` component.

## Instalation

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