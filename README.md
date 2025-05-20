# Bones Theme
An empty Wordpress theme using Vite for comilation and BrowserSync for hot updates.

## Setup

```bash
npm install
```

#### In ```functions.php```
- Set ```PROXY_SOURCE``` in .evn *https://localhost:8888*

#### In ```frontend-config.json``` to reflect the directory of your 
- Update ```themeFolder``` value theme directory name *bt-folder-name*

### Development 
```bash
npm start
```

### Build
```bash
npm run build
```

### Deploy
TODO

### Git FTP
TODO: Set Git FTP settings with 'syncroot' pointing at packages directory. You may need to export any templates if these have been edited in WP.

```
[git-ftp]
        url = ftpes://1.1.1.1/public_html/wp-content/themes/{directory_name}
        user = "username"
        password = "password"
        insecure = 1
        syncroot = package/{directory_name}
```
