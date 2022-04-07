# Bones Theme
An empty framework to build Wordpress themes with Gutenberg using WPack.io for tooling.

## Setup

```bash
npx @wpackio/cli
npm run bootstrap
composer require wpackio/enqueue
```

Update the wpackio.server.js 'proxy' to your local development URL.

```bash
npm run
```

## Development 

Update the ```slug``` value in the ```wpackio.project.js``` to reflect the directory of your theme.

## Build

```bash
npm run build
```

## Deploy

```bash
npm run archive
```