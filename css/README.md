# このテンプレートの使い方

## 用意するもの

* styls

* Git

* nodejs

* npm

## 使い方

主なコマンド

[cssへプリコンパイル]
```
npx parcel watch 'css/**/!(_)*.styl' -d public
もしくは
npm run css
```

[スタイルガイドジェネレーターを起動]
```
npx fractal start --sync
もしくは
npm run fractal
```

## フラクタル

フラクタルを使用してcssのガイドラインを作成します。

## バージョン管理

Git flowを使用してください

git用のルールを参照してください

## ディレクトリ構造

```
.
├── components
│   ├── _sample
│   ├── layout
│   ├── module
│   └── wordpress
├── css
│   ├── layout
│   ├── module
│   └── wp
├── docs
└── public
```

Componentsディレクトリ以下にcssの説明を書き込んでください

docsディレクトリの中身のmdファイルを変更するとガイドラインが編集できます。

publicディレクトリ以下にプリコンパイルされたcssファイルが出力されます。

cssディレクトリ以下にモジュール化をしたファイルを置いてください。プリコンパイルされます。

モジュールを追加したら、cssガイドも追加してください。

wpディレクトリ以下にはwordpress用のcssを置いてください。
