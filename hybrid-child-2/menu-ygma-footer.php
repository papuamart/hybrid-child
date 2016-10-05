<?php
/**
 * YGMA Menu Template
 *
 * Displays the Posttypes Menu if it has active menu items.
 *
 * @package News
 * @subpackage Template
 */

if ( has_nav_menu( 'ygma-menu' ) ) : ?>

	<div id="ygma" class="menu-container">		

			<?php do_atomic( 'before_ygma_menu' ); // Before subsidiary menu hook ?>

		<?php wp_nav_menu( array( 'theme_location' => 'ygma-menu', 'container_class' => 'menu', 'menu_class' => '', 'fallback_cb' => '' ) ); ?>
			
			<?php do_atomic( 'after_ygma_menu' ); // After subsidiary menu hook ?>

	</div><!-- #ygma-menu  .menu-container -->
	
<?php else : ?>

<div id="ygma" class="menu-container">	

			<?php do_atomic( 'before_ygma_menu' ); // Before subsidiary menu hook ?>

<div id="ygmacx">
                    <div id="ygmatop">

	     <div id="ygmafrm" class="sitesearch" style="float:left;">
<? // TOP SIDEBAR ?>
<!-- Site Search Google -->
<form method="get" action="http://www.google.com/custom" target="_top">
<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/google_logo.gif" width="40" height="13" border="0" alt="Google" align="middle"></img>
<input type="hidden" name="domains" value="<?php echo trailingslashit( home_url() ); ?>"></input>
<input type="text" title="Pilih Katakunci untuk Mencari berita dalam situs ini yang telah disimpan di Google ATAU juga bisa cari berbagai berita langsung di Google. Silahkan pilih TOMBOL Web atau di situs ini..." class="yui-tip" name="q" size="31" maxlength="2355" value=""></input>
<input name="sa" type="submit" class="buttons" id="yui-search-button" value='Search' /> 
<input type="radio" name="sitesearch" value="Search Google" ></input>
<font size="-1" color="#000"><?php _e( 'the web', hybrid_get_textdomain() ); ?></font>
&nbsp;&nbsp;
<input type="radio" name="sitesearch" value="<?php echo trailingslashit( home_url() ); ?>" checked="checked"></input>
<font size="-1" color="#000"><?php _e( 'This Site', hybrid_get_textdomain() ); ?></font>
<input type="hidden" name="client" value="005979918960197945866:5hriyk8iv94"></input>
<input type="hidden" name="forid" value="1"></input>
<input type="hidden" name="ie" value="ISO-8859-1"></input>
<input type="hidden" name="oe" value="ISO-8859-1"></input>
<input type="hidden" name="cof" value="GALT:#008000;GL:1;DIV:#336699;VLC:663399;AH:center;BGC:FFFFFF;LBGC:336699;ALC:0000FF;LC:0000FF;T:000000;GFNT:0000FF;GIMP:0000FF;FORID:1"></input>
<input type="hidden" name="hl" value="en"></input>
</form><!-- SiteSearch Google -->
<? // END TOP SIDEBAR ?>
</div>
		
	<div id="ygmafrm">

<!-- Yahoo! Search --><div style="float:right;margin-right:15px;">
<form method="get" action="http://search.yahoo.com/search">
<div><a href="http://search.yahoo.com/">
<img src="http://us.i1.yimg.com/us.yimg.com/i/us/search/ysan/ysanlogo.gif" width="50" height="20" align="left" border="0" /></a>
<input name="p" type="text" style="font-size:14px;" class="yui-tip" title="Silahkan pilih 'the Web' untuk cari di Yahoo!.com atau 'this Site' untuk cari di situs ini ...">
<input name="fr" value="yscpb" type="hidden">
<input class="buttons" value="Search" type="submit">
<span style="font-family:arial,helvetica;"><input name="vs" style="vertical-align: middle;" value="" checked="checked" type="radio"><?php _e( 'the web', hybrid_get_textdomain() ); ?> <input name="vs" style="vertical-align: middle;" value="<?php echo trailingslashit( home_url() ); ?>" type="radio"><?php _e( 'In This Site', hybrid_get_textdomain() ); ?> </span></div>
</form></div>
<!-- End Yahoo! Search -->
                        </div>
                   </div>
            </div>
            </div>
<style>
/* YGMA MENU CSS */
#ygma { font-family:arial; *font-size:small; *font:x-small; width: 100%;border-bottom:1px #ccc solid; }
#ygma div { clear:none }
#ygma strong  { font-weight:bold }
#ygma input   { font-size:99%; font-family: arial }
#ygmatop  { font-size: 77%; font-family:verdana; width:100% }
#ygma { position:relative;text-align:left;zoom:1;margin:0 auto 10px auto }
#ygma:after,#ygmatop:after,#ygmabot:after { content:".";display:block;font-size:0px;line-height:0px;height:0;clear:both;visibility:hidden }
#ygma * { line-height:1.22em }
#ygma em      { font-style:normal }
#ygmalogo img,#ygma ul,#ygma li,#ygma form,#ygma fieldset,#ygma legend { margin:0;padding:0;border:0 }
#ygma ul li,#ygma ol li{ background:none }
#ygma legend  { display:none }
#ygmains1  { float:right;min-height:50px;_height:50px }
#ygmains1 img,#ygma fieldset  { float:none }
#ygmains2  { float:right;margin-right:10px }
#ygmains3  { float:right;margin-left:10px }
#ygmacx    { float:left;width:100% }
#ygmatop {  background:#efefef; padding:0 0 1px;*padding:0;border-bottom:1px solid #dedede;zoom:1 }
#ygnav,#ygmahelp       { list-style:none }
#ygnav li,#ygmahelp li { display:inline;margin-right:7px;list-style:none;zoom:1 }
#ygma #ygnav  { font-size:100%;font-family:arial;float:left;padding:5px 0 0 4px;*padding-top:6px }
#ygma #ygnav a{ color:#666 }
#ygma #ygmalogin       { font-size:122% }
#ygma #ygmafrm{ float:right;text-align:right;padding-right:5px;margin:1px 0 1px;*margin:0 }
#ygma label   { vertical-align:0; *vertical-align: 2px; font-weight:bold; font-family:verdana; color:#666; margin: 0 2px 0 0; *margin-top:-2px }
#ygma .ygbt   { padding:0 5px; font-weight:bold; font-family: verdana; color:#000; overflow:visible; /*background:#ddd;*/ *margin-top: 2px; vertical-align: 1px; *vertical-align: -2px }
/*/ #ygma label,#ygma .ygbt     { vertical-align: 5px } /**/
#ygma #ygsp   { font-size:116%; font-family:arial; margin:1px 3px 0 0; *margin-top:-6px; width:208px; *width: 220px; border: 1px solid #ccc }
#ygmahelp     { font-family:verdana }
#ygmahelp li  { margin-right:4px }
#ygmahelp li.yglast    { padding:0; margin:0 }
#ygmabot      { padding:6px 0 9px; *padding:5px 0 8px; zoom:1; border-top:1px solid #b3b3b3 }
#ygmalogo,#ygmauser    { float:left }
#ygma #ygmalogo{ margin:0 0 0 5px }
#ygmauser     { margin-left:20px; font-family: verdana }
#ygmahelp     { float:right }
#ygmagreeting,#ygmalogin{ display:block }
#ygmamyyhpff  { *display:none }
#ygma .yzq_x  { width:0; height:0 }
#ygnav{ height: 17px }
#ygmatop      { height: 22px }

</style>

			<?php do_atomic( 'after_ygma_menu' ); // After subsidiary menu hook ?>

<?php endif; ?>