# Bones Theme
An empty framework to build Wordpress themes with Gutenberg using WPack.io for tooling. 

For more information on development setup see [wpack.io](https://wpack.io/).

## Setup

```bash
npx @wpackio/cli
npm run bootstrap
composer require wpackio/enqueue
```

#### In ```wpackio.server.js```
- Set a ```proxy``` value to your local URL *http://localhost:8888*
- Set ```host``` to your server's IP address if working remotely

#### In ```wpackio.project.js``` to reflect the directory of your 
- Update ```slug``` value theme directory name *bt-folder-name*

### Development 
```bash
npm run start
```

### Build
```bash
npm run build
```

### Deploy
```bash
npm run archive
```

### Git FTP
Set Git FTP settings with 'syncroot' pointing at packages directory. You may need to export any templates if these have been edited in WP.

```
[git-ftp]
        url = ftpes://1.1.1.1/public_html/wp-content/themes/{directory_name}
        user = "username"
        password = "password"
        insecure = 1
        syncroot = package/{directory_name}
```
