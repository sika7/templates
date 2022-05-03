# コーディングガイドライン簡易版var1.0

## 用意するもの

* gulp

* sass

* pug

* Git

## タスクランナー

gulpを使用する

## バージョン管理

Gitを使用する

### gitのコメント

原則　以下のフォーマットとします。

1行目：変更内容の要約（タイトル、概要）
2行目 ：空行
3行目以降：変更した理由（内容、詳細）

## ディレクトリ構造

### プロジェクトフォルダ

* gulpfile.js [ gulpの命令を書く ] 

* package.json [ 使うパッケージ ] 

* node_modules [ gulpで使うパッケージ ] 

* src [ コンパイル元を格納 ] 

* dist [ コンパイル後を格納 ] 

* workspase [ イラレデータ・テキストなど制作に必要なものを格納 ] 

* .git [ Gitの履歴が格納される ] 

### scr内の構造
 
* images [ 画像を格納 ]  

* js  [ javascriptを格納する ]  

* html_template [ _*pugを格納する ]  

* SCSS [ SCSSファイルを格納 ]  

* fonts [ フォントを格納 ]  

* その他 etc...
　　※imagesの中は各カテゴリ毎(common,news..)にディレクトリを設置すること


## 全体的に言えること

### ユーザーファースト・モバイルファーストで制作する

スマートフォンからコーディングしていく

### コメントを記述する

ブロックごとにコメントを記述する

### 構成要素の分離
見た目に関するものはスタイルシートに、動きに関するものはスクリプトへ移して記述する。

### インデント
 タブキーを一つ使う

### 修正をするとき
コンパイル後のhtmlとcssに変更を加えない
※コンパイルで上書きされ変更が消えます。


## 制作の大まかな流れ
1. pugとsassで作る
1. コンパイルしてhtmlとcssを作る
1. 完成したらcssminiでcssの無駄を省く

※ WordPressのテーマを作成する場合はpugを使用しない。

WordPressのテーマを作成する場合はsassのみ使う

## 画像

### 画像の命名
画像のファイル名は、種類を区別する部分（以下、種類）と個別の名前の部分（以下、個性）に分類します。  
ファイル名には初めに「種類」を次に「個性」を書きます。  
その際、「種類」と「個性」の間に「 _ 」（アンダーバー）を記述し分別します。

```
<例:閉じるボタン>
btn_close.gif
```

|種類|個性|
|:---:|:---:|
|btn_|close|

### 種類の規則
「種類」は種別の判断が出来る英単語を利用します。「種類」の文字数の省略は原則禁止とします。  
文字数が多くなり分かりにくくなる場合は単語で分けます。その場合は単語と単語の間に「 - 」（ハイフン）を入れます。

<例:種類>

|ページタイトル|背景に使用|ボタン|アイコン|
|:---:|:---:|:---:|:---:|
|h_|bg_|btn_|icon_|

### 個性の規則
「個性」も「種類」と同じくそれ自体を判断が出来る英単語を利用します。  
「個性」の文字数の省略も基本的に行わないのが原則です。  
文字数が多くなり分かりにくくなる場合は単語で分けます。
その場合は単語と単語の間に「 - 」（ハイフン）を入れます。

<例:個性>

|検索|トピックス|イベント|メインタイトル|
|:---:|:---:|:---:|:---:|
|search|topics|event|main-title|

### 数字
頻繁に使われるもの（その可能性のあるもの）には個性の後に数字（Number）を記述して対応します。

<例：メニューボタン01>

```
btn_close01.gif
```
このような場合は「種類」、「個性」の後に数字（Number）を記述して対応します。  
こうする事で追加や修正の時に対応がしやすくなります。  
原則として数字（Number）の記述は「個性」に続けて01 から初めてください。  
※だだし「種類」と「個性」が同一のものが3桁（100個）以上になる事が予想されていれば「数字」は 001 から初めてください。


## HTMLのルール

### HTMLファイル
HTMLファイルの命名規則を以下のように定めます。

1. 基本的にそのファイルのページタイトルを英語化し、ファイル名にする。

2. ページタイトルに複数の単語がある際に、ファイル名が長くなりすぎてしまう場合は、単語を1～2個に絞ってファイル名とする。  
例）イベント情報 event-information.html → event.html

3. 同じような形のページが複数個ある場合は連番を利用して命名することも可能とする。  
例）施設 facility01.html、facility02.html、facility03.html…

### HTMLのバリデート
可能な限り適切なHTMLを記述すること。
[「W3C HTML validator」](http://validator.w3.org/nu/)などの検証ツールを使用する。


### HTMLのバージョン

* HTML5を使用する
* エンコードはutf-8を使用する
* タグには小文字を使用する
* セマンティックにタグを使用する

```
<!-- NG -->
<A HREF="/">Home</A>
<!-- 小文字のみの使用。alt属性など文字列は除く。 -->

<!-- OK -->
<img src="google.png" alt="Google">
```


### 省略できるものは省略する

* プロトコル
* CSSとJavaScriptのtype属性は省略する。

```
<!-- NG -->

<script src="http://www.google.com/js/gweb/analytics/autotrack.js"></script>
<!-- プロトコルを省略していない -->

<link rel="stylesheet" href="//www.google.com/css/maia.css" type="text/css">
<!-- type属性を省略していない -->

<script src="//www.google.com/js/gweb/analytics/autotrack.js" type="text/javascript"></script>
<!-- type属性を省略していない -->

<!-- OK -->

<link rel="stylesheet" href="//www.google.com/css/maia.css">

<script src="//www.google.com/js/gweb/analytics/autotrack.js"></script>
```


### マルチメディアの代替コンテンツ
マルチメディアの要素には、代替コンテンツを提供する。
```
<!-- NG -->
<img src="spreadsheet.png">

<!-- OK -->
<img src="spreadsheet.png" alt="Spreadsheet screenshot.">
```


### 全般的な書式

制作段階ではコメントを入れるなどを行いソースコードを見やすく記述する。

```
<blockquote>
    <p><em>Space</em>, the final frontier.</p>
</blockquote>
<!-- メニューここから -->
<ul>
    <li>Moe</li>
    <li>Larry</li>
    <li>Curly</li>
</ul>
<!-- メニューここまで -->
<table>
    <thead>
        <tr>
            <th scope="col">Income</th>
            <th scope="col">Taxes</th>
        </tr>
    <tbody>
        <tr>
            <td>$ 5.00</td>
            <td>$ 4.50</td>
        </tr>
</table>
```
※CMSやpugなどによって、動的に生成される箇所については、この限りではありません。


## CSSスタイルルール

### CSSのバリデート
可能な限り適切なCSSを記述すること。  
CSSバリデーターにバグがある場合や独自の構文を必要としない限りは、ちゃんと書く。  
HTML同様[W3C CSS validator](http://jigsaw.w3.org/css-validator/)などのツールで検証する。


### reset.css

リセットcssもしくはNormalize.cssを使う 


### css設計

FLOCCSをベースとして使う

そのほか必要に応じて変更します。


### セレクタの命名ルール

* 原則クラス名のみのする
* 原則ネストしない
* 区切り文字にはキャメルケースを使う
* 意味の分かる名前を使う
* タイプセレクタは使用しない

```
/* NG */
.yee1901 {} /* 役割を表していない */
.buttonGreen {} /* 役割を表していない */
.clear {} /* 役割を表していない */
.demo-image {} /* ハイフンで繋がってる */
.error_status {} /* アンダーバーで繋がってる */
ul#example {} /* タイプセレクタで記述している */
div.error {} /* タイプセレクタで記述している */

/* OK */
.gallery {}
.globalNav {}
.menuList{}
```


### プロパティ

原則として見通しが良いように省略を使い記述する。


* ショートハンドプロパティ
* HEX形式のカラーコード


```
/* NG */
padding-bottom: 2em;
padding-left: 1em;
padding-right: 1em;
padding-top: 0;
/* ショートハンドを使っていない */

/* OK */
padding: 0 1em 2em;
```


## CSS書式ルール

原則として見通しが良いように記述する。

* 階層がわかるようにブロック単位でコードをインデントする
* プロパティの終端
* プロパティ名の終端
* セレクタとプロパティの分離
* CSSルールの分離


```
/* NG */
.wrapper {
  display: block;
  height: 100px
}
/* すべてのプロパティの終端はセミコロンを書くこと。 */

.hoge {
  font-weight:bold;
}
/* すべてのプロパティ名の終端にはコロンの後に半角スペースを入れること。 */

a:focus, a:active {
  position: relative; top: 1px;
}
/* 別々のセレクタとプロパティは改行して書くこと。※セレクターが沢山ある場合(reset.css内など)は除外 */

html {
  background: #fff;
}
body {
  margin: auto;
  width: 50%;
}
/* 別々のCSSルールは改行して一行間を空けて書く。 */

/* OK */
@media screen, projection {
  .wrapper {
    background: #fff;
    color: #444;
  }

  .hoge {
  display: block;
  height: 100px;
  }

  h1,
  h2,
  h3 {
  font-weight: normal;
  line-height: 1.2;
  }
}
```

### CSSハック
ユーザーエージェント別の対応のためにCSSハックを使う前に別の方法を試してみること。
CSSハックは、ユーザーエージェントごとの違いを吸収するためには簡単で魅力的な方法だけど、プロジェクト全体のコードの品質を落とすことにもなるので「最後の手段」として考えること。

### レスポンシブデザイン
メディアクエリーを使う

※モバイルファーストでスマホからスタイルする

```
/*
@media以外の所は全てのサイズで読み込まれます。
*/

@media screen and (max-width:768px) {
	/*画面サイズが768px以下*/
	
}
```