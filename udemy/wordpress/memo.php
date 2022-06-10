<!-- 
■テンプレート階層
index.phpは最低限必要。無いとテーマとして機能しない。
ブログ投稿はsingle-post.phpにつながっていてそれは、最終的にindex.phpにつながっている。
テンプレート階層の左側に配置されているほど優先度の高いテンプレートとなっている。
機能に応じて必要なテンプレートを作り込んでテーマを作る。

現在どのファイルが使われているのかテンプレート階層から探し出すのは
難しい作業になる。
そこでそれを助けてくれるプラグインがquery monitorになる。

webサイトの上の管理バーで確認できる

■必須ファイル
自作するときにテーマとして認識される為にはindex.phpとstyle.cssが必須
style.cssは必ず必要だがスタイルを絶対に書かないといけないわけでは無い
他のcssを使うでもよし
style.cssはテーマの設定ファイルの役割を担っている
例えばテーマの名前を以下と記述するとGUIのテーマ名が変更される
（設定についてはコメントにする必要がある）
以下の左側の部分はキーと呼ばれる

/* 
Theme Name:テルテーマ
Version:1.0
Author:テル

*/
■コーデックス公式ドキュメント
以下がコーデックス公式ドキュメントに書かれているテーマ開発で使用できるキーになる。
以下は自分だけが使用する場合は必要なやつだけ書く。
配布する場合は全て必須（配布する場合は日本語は使えない、英語のみ）

/*
Theme Name: Twenty Thirteen
Theme URI: http://wordpress.org/themes/twentythirteen
Author: the WordPress team
Author URI: http://wordpress.org/
Description: The 2013 theme for WordPress takes us back to the blog, featuring a full range of post formats, each displayed beautifully in their own unique way. Design details abound, starting with a vibrant color scheme and matching header images, beautiful typography and icons, and a flexible layout that looks great on any device, big or small.
Version: 1.0
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Tags: black, brown, orange, tan, white, yellow, light, one-column, two-columns, right-sidebar, flexible-width, custom-header, custom-menu, editor-style, featured-images, microformats, post-formats, rtl-language-support, sticky-post, translation-ready
Text Domain: twentythirteen

This theme, like WordPress, is licensed under the GPL.
Use it to make something cool, have fun, and share what you've learned with others.
*/


■子テーマ
通常既存のテーマなどを上書きするときには子テーマというものを作る。
themeフォルダに新規でフォルダを作って、そのフォルダに新しく名前をつける。
そのフォルダにstyle.cssに設定を書くがTemplate:twentytwentyは必須。
参照したテンプレートテーマを書く必要がある。
そうすると自動的に現在作ったフォルダはTemplate:twentytwentyの子テーマと認識する。
twentytwentyが親テーマになる。

「重要」
子テーマは親テーマの各機能やテンプレートファイル群を引き継いて作ることができる。
ただ、スタイルシートは引き継がれない。
主に既存テーマをカスタマイズしたいという場合にはこのように子テーマを作ってから
カスタマイズする。


■テンプレートタグ
the_title();投稿のタイトルで使う
テンプレートタグは通常のphpでは使えずwordpress内でしか使えない
引数がオプションだった場合は任意
必須だった場合は必ず書く

必ず記述するテンプレートタグ
・wp_head()
⇨</head>の直前に必要。
・wp_footer()
⇨</body>の直前に必要。

上記、管理ツールバーを表示させる、プラグインを動作させる等のwordpressでの動作を
有効とするものなので必ず必要となる。

■if構文
wordpressのif構文は最後に{}ではなく、コロン(:)で終わり、最後にendif;とする
条件以外の場合はelseとする
書き方は以下

以下のif構文は投稿が見つかったら表示、見つからなかったらエラー文を表示
これはどのページにも決まり文句として書く
404エラーページは作るものの動作しなくなった時のために二重にしとく(バグを回避するため)
single.phpはelseとなることはほぼないのでelse不要


<?php if(have_posts()): ?>
<?php else:?>
    <p>記事が見つかりませんでした。</p>
<?php endif; ?>


<?php if (true または false): ?>
    tureの時に表示される内容
<?php else: ?>
        falseの時に表示される内容
<?php endif; ?>


投稿があるか無いかhave_posts()
この関数は現在の WordPress クエリにループできる結果があるかどうかをチェックします。ブール型関数で、TRUE または FALSE を返します。
成功時に true、失敗時に false


shift + option + Fでファイル全体のインデントを揃えてくれる


■投稿
以下のpostで最新の投稿を取得してtitleで表示をする
このセットを二つ書くと最新の次の投稿を表示する
このように以下セットの数だけ投稿が表示できるのでループを回してあげた方が効率的かつ変更に強くなる

<?php the_post(); ?>
<?php the_title(); ?>
the_title()は必ずループの中で使用してください。
ループの外では get_the_title() を使います。

<?php the_post(); ?>
<?php the_title(); ?>

while文で条件にhave_posts()公開されている投稿で、まだ表示されていない最新の投稿を探して表示する
the_postは次の投稿に進める役割を持っている
一回目のループでhave_postsで探して最新を表示する、その時にthe_postで次の投稿に移って
二回目のループで一回目の投稿以外で最新を探して表示する、またthe_postで次の投稿に移る
といった形で投稿を表示する流れになっている
投稿が無くなった段階でhave_postsの返り値がfalseとなるので処理終了となる

<?php while (have_posts()) : ?>
    <?php the_post(); ?>
    <?php the_title(); ?>
<?php endwhile; ?>


whileは条件がtrueの場合はずっと繰り返してしまうので
条件のtrue,falseで書くが正確には、最初はtrueで、最後にfalseになる値とする必要がある
<?php while (条件:true/false)?>
    繰り返したい内容
<?php endwhile; ?>

■日付the_date()
記事の投稿/更新日を出力。PHPの日付文法が使用できる。同じ日に複数の記事がある場合は、最初の記事とともに一度だけ出力される。
同じ日を繰り返したい場合はget_the_date()かthe_time()を使用する必要がある
the_time()はデフォルトでは時間しか表示されないので、フォーマットを変えて日付まで表示する必要がある
以下で表示される
the_time('Y/m/d');

ダッシュボードで設定した日付を呼び出すだと以下の書き方がある
the_time(get_option('date_format'));

■サブタイトル（抜粋）
the_excerpt()はサブタイトルを表示するために用いる
投稿の内容の一部が抜粋されて表示される
200文字ぐらい
the_excerpt();の挙動は管理画面の該当の投稿の設定にある抜粋項目に入力があったらそれをサブタイルにするが
入力されていない場合は投稿の一部を抜粋するという挙動になる
抜粋のコンテンツからは HTML タグと画像は取り除かれる
基本は抜粋入力欄に記載をしておいた方が見栄えが良くなる

■著作権
the_author()ではwordpressで設定したユーザ名が表示される


■ファイル構造
ページが細分化されているほどテンプレート階層の左側を選んで使う
テンプレート階層も左にいくほど細分化されている
最も適したファイル構造にする


■headerとfooter
headerとfooterはパーツかした方がいい
ccsの読み込みも一つにまとめておけば個別に修正しなくて良くなる
上記二つは他のページに行っても変わらないケースがほとんどだから

udemyの先生はheaderに関するもの全てをheader.phpに入れるのではなく
headタグで読み込んでいる設定だけをheader.phpにいれることによって
ページの全体像がわかりやすくなるから
footerに関してもbody終了タグの直前にjavacript等の読み込みがあるので
設定に関するものだけをパーツ化する
また、navタグやfooterタグも繰り返し使うが上記先生のやり方だとheader.phpに
含めないので繰り返し書く必要があると思いがちだが、navタグやfooter等は個別でパーツ化
することによってとても管理がしやすくなる(一つのファイルに全て書かれていると管理がしにくい、可読性が低くなる)
例えばプロジェクトファイルの中にincludesというフォルダを作ってその中にheader.phpを作り、
その中にnavタグを入れることによってファイルを分割してパーツ化することができる
footerタグに関してもincludesの中にfooter.phpを作って、footerタグを入れることによって分割して
パーツ化することが可能
上記、分割してパーツ化した際は、元々記述のあった場所に以下を記述することによって反映することができる
引数の中にシングルクォーテーションでフォルダ名/ファイル名を記述する
ファイル名の後ろに拡張子は書く必要がない

get_template_part('includes/footer');



■サイドバー
sideber.phpはサイトによってあったりなかったりするので状況に応じて作る

■headタグ内のタイトル
パーツかしたが全てタイトルを同じにするわけではなくて投稿ページに遷移した場合は
投稿ページのタイトルにしたい場合はheadタグ内のtitleにthe_title()を記述することによって
それぞれのタイトルを取得してくれるのでその方法がよろしい


■linkタグを相対的にするテンプレートタグ
linkタグを絶対的に記述するとサーバ引越しやドメイン変更等でミスが起こりやすいので
テンプレートタグを使って相対的にする必要がある
echo get_template_directory_uri();
footerに関しても同じようにする


後はfontやアイコンのURLでhttpプロトコル部分は省略できる
http,httpsどっちになっても良いように省略形で記述をする

省略前）http//fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic
省略後）//fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic


■ループ
通常のループとwordpressのループは定義が違う
wordpressでは投稿で使用するもの、
投稿が一件であっても、複数件であっても投稿を表示する場合はループを使用する必要がある

「ループ」は、WordPress の投稿を表示するために使われるPHPコードです。このループを使えば、現在のページに表示される各投稿を処理したり、ループタグ内で指定された条件に沿って投稿の形式を整えたりできます。ループの開始部分と終了部分の間に書きこんだ HTML や PHP のコードは、各投稿の表示に使われます。

テンプレートタグやプラグインの説明内に「このタグ（プラグイン）はループ内で使います」とある場合、タグが各投稿で繰り返して表示されます。例として、以下が各投稿にデフォルトでループ内に含まれます。

投稿のタイトル - the_title()
投稿の公開日時 - the_time()
属するカテゴリー - the_category()


■アイキャッチ画像
アイキャッチ画像をダッシュボードで操作するためにはfunctions.phpが必要になる
functions.phpはwordpressの様々な設定、動作のカスタマイズをする
以下を記述するとダッシュボードに表示される
add_acitonがフックという役割をしていて、initで初期化した時に、add_theme_supportでテーマに対してサポートする項目を増やしている
add_theme_support()の引数にpost-thumbnailsを指定することでサムネイル(アイキャッチ画像)をサポートしてほしいと命令を出している
add_action('init', function() {
    add_theme_support('post-thumbnails');
});

functions.phpは関数を再利用するためにも使うことができる


the_post_thumbnail()でアイキャッチ画像を表示
投稿編集画面で設定されたアイキャッチ画像（以前は投稿サムネイルと呼ばれていました）を表示します。
このタグはループ内でのみ使えます。
第一引数にはサイズを指定、第二引数では属性を指定することができる
以下は配列で複数指定していて、第二引数では連想配列にて指定をしている
the_post_thumbnail(array(32,32), array('alt'=> 'アイキャッチ画像')
ただ、the_post_thumbnail()は画像全て取得してしまう
srcに入るURLを取り出したい時に以下の二行を記述する



投稿のアイキャッチ画像（投稿サムネイル）がセットされている場合はアイキャッチ画像のIDを返す関数
アイキャッチ画像がなければ、空文字を返す。投稿が存在しなければfalseを返す
$id = get_post_thumbnail_id();

添付された画像ファイルの"url","width","height"属性を配列として返す関数
添付された画像とはダッシュボードのメディアライブラリの中にある画像全てを指す
引数には画像URLの最後にあるitem=25のようなIDを指定する
第一引数は画像のIDで、第二引数はオプションとして、サイズを指定する
wordpressでは以下のサイズを指定するか、サイズの縦横を直接指定するのどちらかである
(thumbnail, medium, large, full)
$img = wp_get_attachment_image_src($id);

largeと指定するのが一般である
fullは大きすぎる
ダッシュボード⇨設定⇨メディアでthumbnail, medium, large, fullのサイズを変更することができる

デフォルトで画像を指定することで画像がなかった場合はデフォルトが指定されるようにする
has_post_thumbnail()は投稿にアイキャッチ画像（以前は投稿サムネイルと呼ばれていました）が
登録されているかどうかをチェックする関数
      if (has_post_thumbnail()) :
        $id = get_post_thumbnail_id();
        $img = wp_get_attachment_image_src($id, 'large');
      else :
        $img = array(get_template_directory_uri() . '/img/post-bg.jpg');
      endif;
以下、style属性で出力している（配列の0番目に画像のURLが指定されている）
      style="background-image: url('<?php echo $img[0] ?>')"



■パラメータの確認
var_dump();
javascriptのconsole.logみたいなもの


■変数、配列、連想配列
・変数
    $num = 1; 
    echo $num;
・配列
$tomosta = [];
$tomosta = array();

$tomosta[0] = 'Yamada';

・連想配列
$item = [];
$item['apple'] = 'りんご';

■htmlタグのlanguage属性
language_attributes();を使うことによってwordpressで設定した言語で表示されるようになる
<html lang="ja">
<html <?php language_attributes(); ?>>


■bodyタグのテンプレートタグ
クラスを付加してstyleシートの調整やjavascriptの制御する
bodyのクラスを見るとwordpressの今の状況がどのような状況かをある程度知ることができる

<?php body_class(); ?>

例えばGoogleのタグマネージャといったようなツールを入れる時にbodyタグが開いた直後に
何かを入れてくださいと指示がある場合がある
そのような時にプラグインなどでbodyタグが開いた直後に出力するケースがあるので以下のタグも
入れておくとそういったプラグインで対応できる
<?php wp_body_open(); ?>

bodyタグの直後に書く必要がある為、includesの中にheader.phpを用意していてbodyタグの直後で
読み込んでいる場合はincludes/header.phpの一番上に書くことで全シートに反映できる


■固定ページ
投稿は日付順に並んでいくが、固定ページは並び順はなく、メニューとかに使われることが多い
テンプレートファイルとしてpage.phpを使う
理由としてはsingular.phpで投稿と固定を一緒にしておらず、投稿ページとしてsingle.phpを使っている為
詳細はテンプレート階層を確認する


■URL
URLは大体が日本語対応していない為、英語で書くのが好ましい
実際にコピーで持ってくると文字化けしてしまう
理由としてはURLエンコードが英語だから

以下はブラウザ表示だとhttp://mysite.local/テストとなっていたがいざ持ってくると文字化けしてしまう
http://mysite.local/%e3%83%86%e3%82%b9%e3%83%88/

■パーマリンク
URLを設定できる

・URL スラッグとは位置を示す記号という意味を持つ。そのページを示す記号。


wordpressでは固定ページ編集の画面でページ属性という設定で階層構造を作ることができる

投稿ページのURLは以下で表示されてしまう。もちろん持ってくると文字化けしている
http://mysite.local/2022/06/抜粋の練習です。/

投稿ページは日々運用していくとたくさん出来上がるのでそのたんびにURLスラッグを決めていたら労力がかかりすぎる為
パーリンク設定で/%year%/%monthnum%/%post_id%/とカスタム設定にする
最後のIDで投稿どの投稿かすぐわかるので良い。udemyの先生もそうやっている

まぁ自分の好きなようにカスタマイズするのが一番らしい！


■contact form
大体contact form 7かmw wp formのどちらかが使われている
wordpressの練習ではmw wp formを使う

お問合せフォームを作るときは先にhtmlでお問い合わせフォームを組み立てて、
その後、wordpressの方で独自のショートコードに変換していく流れになる
完成したら固定ページで作ってあったお問い合わせページにショートコードを貼り付ける



■カテゴリとタグ
カテゴリは投稿の親子関係を作ることができる
タグはその投稿をしめすもの、そして、タグはカテゴリを親として振り分けることができる
投稿でカテゴリを設定せずに投稿すると皆、UNcategorizedというカテゴリに入る
ダッシュボード⇨設定⇨投稿設定でデフォルトで振り分けられるカテゴリを選択することができるが
何も洗濯しないということはできない
カテゴリはあまり多く作ると振り分けが大変なので、多くても10個程度に収める
より、詳細な分類にしたい場合はタグを使う





-->