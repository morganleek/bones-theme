# Bones Theme
An empty framework to build Wordpress themes with Gutenberg using WPack.io for tooling. 

For more information on development setup see [wpack.io](https://wpack.io/).

## Setup

```bash
npx @wpackio/cli
npm run bootstrap
composer require wpackio/enqueue
```

Update ```proxy``` value in ```wpackio.server.js```  to your local development URL. I.e. *http://localhost:8888/*
Update ```slug``` value in ```wpackio.project.js``` to reflect the directory of your theme. I.e. *bt-helm*

## Development 
```bash
npm run start
```

## Build

```bash
npm run build
```

## Deploy

```bash
npm run archive
```
