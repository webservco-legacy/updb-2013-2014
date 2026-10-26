# updb-2013-2014

The first version of UPDb, the Underground Press Database (2013 and 2014): a PHP and MySQL web app to catalogue fanzines
and other underground publications, with user accounts, collections, want and trade lists, in English and Romanian, on my
WEb framework. A historical archive, kept read-only: the PHP code of its time, not safe to deploy today, kept for its
history. The current code is [updb](https://github.com/webservco/updb).

## History

| Date | Commit | |
|---|---|---|
| 2013-09-14 | 2c13547 | the first commits: the app's folders and the database |
| 2013-09-22 | 48d0d7a | the users' lists (collection, want and trade lists) |
| 2013-09-25 | e2c5c1a | the publication layout |
| 2013-10-24 | f9951a7 | the last Subversion commit before the dump (r50) |
| 2014-04-28 | 7e223bf | r51 to r55, from a working copy of 2014 |

The branch `working-copy-2013-12` holds the files of a working copy of 2013-12 that Subversion did not have.

## What is in it

- `src/app/`: the app (controllers, modules, the templates, the configs, the translations);
- `src/web/`: the web root (`index.php`, the skin, the scripts);
- `src/database/`: the MySQL Workbench model, the lookup data and some queries (the schema dump of 2013, without
  rows, is in the history);
- `extra/`: my first notes on the idea.

The app runs on WEb, which is not in this repository: see
[web-2012-2017](https://github.com/webservco-legacy/web-2012-2017).

Left out of the whole history: the cover images of the zines (other people's work) and two web fonts without a licence.

## How it was built

From my Subversion repository (r1 to r50) and a working copy with r51 to r55 (their log messages lost), turned into git in
2026 (52 commits on all branches), the dates kept. The last commit before this README sets LF line endings and
indents with spaces.

## Third-party code

Bundled as it shipped, each under its own licence: jQuery 1.10.2 and jQuery UI 1.10.3 with its UI Lightness theme (MIT),
PhotoSwipe 3.0.5, klass and Modernizr 2.6.2 (MIT), html5shiv (MIT or GPL v2); the fonts Bitstream Vera Sans Mono
(Bitstream Vera licence) and Underwood Champion by Vic Fieger (freeware, with its licence file).

## Licence

New BSD (`LICENSE`), as the file headers say; the `LICENSE` file was added in 2026.
