<?php
/*
=====================================================
 MWS Smart Installer
-----------------------------------------------------
 Author: Mehmet Hanoğlu
-----------------------------------------------------
 Mail: mehmethanoglu@dle.net.tr
-----------------------------------------------------
 License : MIT License
=====================================================
*/

if ( ! defined( 'E_DEPRECATED' ) ) {
	@error_reporting ( E_ALL ^ E_NOTICE );
	@ini_set ( 'error_reporting', E_ALL ^ E_NOTICE );
} else {
	@error_reporting ( E_ALL ^ E_DEPRECATED ^ E_NOTICE );
	@ini_set ( 'error_reporting', E_ALL ^ E_DEPRECATED ^ E_NOTICE );
}

define ( 'DATALIFEENGINE', true );
define ( 'ROOT_DIR', dirname ( __FILE__ ) );
define ( 'ENGINE_DIR', ROOT_DIR . '/engine' );
define ( 'LANG_DIR', ROOT_DIR . '/language/' );

require_once ENGINE_DIR . "/inc/include/functions.inc.php";
require_once ENGINE_DIR . "/data/config.php";
require_once ENGINE_DIR . "/classes/mysql.php";
require_once ENGINE_DIR . "/data/dbconfig.php";
require_once ENGINE_DIR . "/modules/sitelogin.php";
require_once ENGINE_DIR . "/classes/install.class.php";

@header( "Content-type: text/html; charset=" . $config['charset'] );
require_once LANG_DIR . $config['langs']."/adminpanel.lng";


$Turkish = array ( 'm01' => "Kuruluma Başla", 'm02' => "Yükle", 'm03' => "Kaldır", 'm04' => "Yapımcı", 'm05' => "Çıkış Tarihi", 'm08' => "Kurulum Tamamlandı", 'm10' => "dosyasını silerek kurulumu bitirebilirsiniz", 'm11' => "Modül Kaldırıldı", 'm21' => "Kuruluma başlamadan önce olası hatalara karşı veritabanınızı yedekleyin", 'm22' => "Eğer herşeyin tamam olduğuna eminseniz", 'm23' => "butonuna basabilirsiniz.", 'm24' => "Güncelle", 'm25' => "Site", 'm26' => "Çeviri", 'm27' => "Hata", 'm28' => "Bu modül DLE sürümünüz ile uyumlu değil.", 'm29' => "Buradan sürümünüze uygun modülü isteyebilirsiniz" );
$English = array ( 'm01' => "Start Installation", 'm02' => "Install", 'm03' => "Uninstall", 'm04' => "Author", 'm05' => "Release Date", 'm06' => "Module Page", 'm07' => "Support Forum", 'm08' => "Installation Finished", 'm10' => "delete this file to finish installation", 'm11' => "Module Uninstalled", 'm21' => "Back up your database before starting the installation for possible errors", 'm22' => "If you are sure that everything is okay, ", 'm23' => "click button.", 'm24' => "Upgrade", 'm25' => "Site", 'm26' => "Translation", 'm27' => "Error", 'm28' => "This module not compatible with your DLE.", 'm29' => "You can ask for compatible version from here" );
$Russian = array ( 'm01' => "Начало установки", 'm02' => "Установить", 'm03' => "Удалить", 'm04' => "Автор", 'm05' => "Дата выпуска", 'm06' => "Страница модуля", 'm07' => "Форум поддержки", 'm08' => "Установка завершена", 'm10' => "удалите этот фаля для окончания установки", 'm11' => "Модуль удален", 'm21' => "Сделайте резервное копирование базы данных для избежания возможных ошибок", 'm22' => "Если вы уверены что всё впорядке, ", 'm23' => "нажмите кнопку.", 'm24' => "обновлять", 'm25' => "сайт", 'm26' => "перевод" );
$lang = array_merge( $lang, $$config['langs'] );

function mainTable_head( $title ) { echo "<div class=\"box\"><div class=\"box-header\"><div class=\"title\"><div class=\"box-nav\"><font size=\"2\">{$title}</font></div></div></div><div class=\"box-content\"><table class=\"table table-normal\">"; }
function mainTable_foot() { echo "</table></div></div>"; }
function Table_head( $title ) { echo "<div class=\"box\"><div class=\"box-header\"><div class=\"title\"><div class=\"box-nav\"><font size=\"2\">{$title}</font></div></div></div><div class=\"box-content\">"; }
function Table_foot() { echo "</div></div>"; }

$module = array(
	'name'		=> "Test Modülü v1.0",
	'date'		=> "xx.xx.2014",
	'ifile'		=> "install_module.php",
	'file'		=> "test_module.xml",
	'link'		=> "http://dle.net.tr",
	'image'		=> "http://img.dle.net.tr/mws/simple_bb.png",
	'author_n'	=> "Mehmet Hanoğlu (MaRZoCHi)",
	'author_s'	=> "http://mehmethanoglu.com.tr",
);


if ( $is_logged && $member_id['user_group'] == "1" ) {

	$js_array[] = "engine/classes/highlight/highlight.code.js";

	echoheader("<i class=\"icon-comments\"></i>" . $module['name'], $lang['m01'] );
echo <<< HTML
<script>function done_edit( id ) { $("tr#edit_" + id).fadeOut(); }</script>
<style type="text/css">.primary-sidebar,.newsbutton,.navbar-right,.sidebar-background,.pull-right,.navbar-toggle,.navbar-collapse-top{display:none;} .main-content{margin:0!important;} .box{ width: 75%; margin: auto !important;}</style>
HTML;


	if ($_REQUEST['action'] == "install") {
		
		$mod = new VQEdit();
		$mod->backup = True;
		$mod->bootup( $path = ROOT_DIR, $logging = True );
		if ( $config['version_id'] == "10.2" ) {
			$mod->file( ROOT_DIR. "/install/xml/" . $module['file'] );
		} else {
			mainTable_head( $lang['m27'] );
			echo "<div style=\"padding:10px; background: #990000; color: #fff;\">{$lang['m28']}<br />{$lang['m29']} :<br /><br /><i>{$module['link']}</i></div>";
			mainTable_foot();
			echofooter();
			die();
		}
		$mod->close();
		mainTable_head( "Kurulum Bitti" );
		$stat_info = str_replace("install.php", "install_module.php", $lang['stat_install'] );
		echo <<< HTML
	<table width="100%" class="table table-normal">
		<tr>
			<td width="210" align="center" valign="middle" style="padding:4px;">
				<img src="{$module['image']}" alt="" />
			</td>
			<td style="padding: 10px;" valign="top">
				<b><a href="{$module['link']}">{$module['name']}</a></b><br /><br />
				<b>{$lang['m04']}</b> : <a href="{$module['author_s']}">{$module['author_n']}</a><br />{$translation}
				<b>{$lang['m05']}</b> : <font color="#555555">{$module['date']}</font><br />
				<b>{$lang['m25']}</b> : <a href="{$module['link']}">{$module['link']}</a><br />
				<br /><br />
				<b><font color="#BF0000">{$module['ifile']}</font> {$lang['m10']}</b><br />
			</td>
		</tr>
		<tr>
			<td width="150" align="left" style="padding:4px;">
				<input type="button" onclick="window.location='http://dle.net.tr'" value="DLE.NET.TR" class="btn btn-blue" />
			</td>
			<td colspan="1" style="padding:4px;" align="right">
				<input type="button" onclick="window.location='{$config['http_home_url']}'" value="Siteye Git" class="btn btn-green" />
			</td>
		</tr>
	</table>
HTML;
		mainTable_foot();
	} else if ($_REQUEST['action'] == "manuel") {
		$xmlstr = file_get_contents( ROOT_DIR. "/install/xml/" . $module['file'] );
		$xml = new SimpleXmlElement( $xmlstr );
		$_EDITIONS = array(); $proc_count = 0;
		foreach( $xml->file as $e ) {
			$file = strval( $e->attributes() );
			if ( isset( $e->operation[0] ) ) { foreach( $e->operation as $a ) { $_EDITIONS[ $file ][] = array( 'ignoreif' => htmlentities( trim( $a->ignoreif ), ENT_QUOTES ), 'search' => htmlentities( trim( $a->search ), ENT_QUOTES ), 'add' => htmlentities( trim( $a->add ), ENT_QUOTES ), 'operation' => $a->search->attributes() ); } }
			else { $_EDITIONS[ $file ][] = array( 'ignoreif' => htmlentities( trim( $e->operation->ignoreif ), ENT_QUOTES ), 'search' => htmlentities( trim( $e->operation->search ), ENT_QUOTES ), 'add' => htmlentities( trim( $e->operation->add ), ENT_QUOTES ), 'operation' => $e->operation->search->attributes() ); }
			$proc_count = $proc_count + count( $_EDITIONS[ $file ] );
		}
		Table_head("Manuel Kurulum");
		$edit_count = count( $_EDITIONS );
		ksort( $_EDITIONS );
echo <<< HTML
<div class="row box-section">
	<div class="alert alert-info">Kurulumda aldığınız hata nedeniyle bu işlemleri manuel yapmalısınız. Her dosya düzenlemesinden önce o dosyanın yedeğini almayı unutmayın. Olası hata durumunda sitenizi en kısa sürede tekrar aktif etmek için size kolaylık sağlayacaktır.<br />
	Düzenleme yapılacak toplam dosya sayısı: {$edit_count}&nbsp;&nbsp;-&nbsp;&nbsp;Toplam düzenleme işlemi sayısı: {$proc_count}</div>
	<div class="alert alert-danger"><b>Dikkat:</b> Burada yapacağınız düzenlemeler, sadece "Otomatik Kuruluma" dahil olan düzenlemelerdir. Ek olarak verilen diğer düzenlemeleri içermez.</div>
	<div class="accordion" id="accordion">
HTML;
		$file_count = 0;
		foreach ( $_EDITIONS as $file => $operations ) {
			$file_hash = md5( $file );
			$file_count++;
echo <<< HTML
<div class="accordion-group">
	<div class="accordion-heading">
		<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#{$file_hash}">{$file_count}) Aç - {$file}</a>
	</div>
	<div id="{$file_hash}" class="accordion-body collapse">
		<div class="accordion-inner padded">
HTML;
			foreach ( $operations as $opid => $operation ) {
				$process = "";
				if ( isset( $operation['operation']->index ) ) { $process .= "Sayfada, baştan  " . $operation['operation']->index . ". eşleşme"; }
				if ( isset( $operation['operation']->offset ) ) { $process .= $operation['operation']->offset . " satır"; }
				$pro_lang = array( "before" => "Üstüne ekle", "replace" => "İle değiştir", "after" => "Altına ekle", "ibefore" => "Hemen öncesine ekle", "iafter" => "Hemen sonrasına ekle", );
				$_pp = strval( $operation['operation']->position );
				$do_it = ( ! empty( $process ) ) ? $pro_lang[ $_pp ] . " (" . $process . ")" : $pro_lang[ $_pp ];
echo <<< HTML
				<h5>Varsa, ekleme:</h5>
				<div class="code"><pre><code class="php">{$operation['ignoreif']}</code></pre></div>
				<h5>Bul:</h5>
				<div class="code"><pre><code class="php">{$operation['search']}</code></pre></div>
				<h5>{$do_it}:</h5>
				<div class="code"><pre><code class="php">{$operation['add']}</code></pre></div>
				<hr />
HTML;
			}
echo <<< HTML
		</div>
	</div>
</div>
HTML;
		}
		Table_foot();
echo <<< HTML
	</div>
</div>
<script>hljs.initHighlightingOnLoad();</script>
HTML;

	} else {

		mainTable_head( $lang['m01'] );
		echo <<< HTML
	<table width="100%" class="table table-normal">
		<tr>
			<td width="210" align="center" valign="middle" style="padding:4px;">
				<img src="{$module['image']}" alt="" />
			</td>
			<td style="padding: 10px;" valign="top">
				<b><a href="{$module['link']}">{$module['name']}</a></b><br /><br />
				<b>{$lang['m04']}</b> : <a href="{$module['author_s']}">{$module['author_n']}</a><br />{$translation}
				<b>{$lang['m05']}</b> : <font color="#555555">{$module['date']}</font><br />
				<b>{$lang['m25']}</b> : <a href="{$module['link']}">{$module['link']}</a><br />
				<br /><br />
				<b><font color="#BF0000">{$lang['m01']} ...</font></b><br /><br />
				<b>*</b> {$lang['m21']}<br />
				<b>*</b> {$lang['m22']} <font color="#51A351"><b>{$lang['m02']}</b></font> {$lang['m23']}<br />
			</td>
		</tr>
		<tr>
			<td width="150" align="left" style="padding:4px;"></td>
			<td colspan="1" style="padding:4px;" align="right">
				<form method="post" action="{$PHP_SELF}">
					<input type="hidden" value="manuel" name="action" />
					<input type="submit" value="Manuel Kurulum" class="btn btn-gold" />
				</form>
			</td>
HTML;
if ( class_exists( 'SimpleXmlElement' ) && function_exists( 'file_get_contents' ) ) {
echo <<< HTML
			<td colspan="1" style="padding:4px;" align="right">
				<form method="post" action="{$PHP_SELF}">
					<input type="hidden" value="install" name="action" />
					<input type="submit" value="{$lang['m02']}" class="btn btn-green" />
				</form>
			</td>
		</tr>
	</table>
HTML;
}
		mainTable_foot();
	}
	echofooter();
} else {
	msg("home", $lang['mws_noauth'], $lang['mws_noauth_text'], $config["http_home_url"]);
}
?>
