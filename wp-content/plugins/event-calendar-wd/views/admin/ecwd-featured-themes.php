<?php

class ECWDFeaturedThemes {


    private $slug = 'eventcalendarwd';
    private $lang_slug = 'ecwd';

    private $image_url = '';
    private $demo_url = 'http://themedemo.web-dorado.com/';
    private $site_url = 'https://web-dorado.com/wordpress-themes/';

    public function __construct() {
        $this->image_url = ECWD_URL . "/css/featured_themes/";
    }

    ////////////////////////////////////////////////////////////////////////////////////////
    // Public Methods                                                                     //
    ////////////////////////////////////////////////////////////////////////////////////////

    public function display() {
        ?>

        <style>
            @import url(https://fonts.googleapis.com/css?family=Oswald);

            #main_featured_themes_page #featured-themes-list {
                position:relative;
                margin:0px auto;
                height:auto;
                display:table;
                list-style:none;
                text-align: center;
                width: 100%;
            }
            #main_featured_themes_page #featured-themes-list li {
                display: inline-table;
                width: 300px;
                margin: 20px 10px 0px 10px;
                background: #FFFFFF;
                border-right: 3px solid #E5E5E5;
                border-bottom: 3px solid #E5E5E5;
                position: relative;
            }
            @media screen and (min-width: 1600px) {
                #main_featured_themes_page #featured-themes-list li {
                    width:400px;
                }

            }
            #main_featured_themes_page .theme_img img {
                max-width: 100%;
            }
            #main_featured_themes_page .theme_img {
                display: inline-block;
                overflow: hidden;
                outline: 1px solid #D6D1D1;
                position:relative;
                /*height: 168px;	*/
            }
            #main_featured_themes_page #featured-themes-list li  .title {
                width: 91%;
                text-align: center;
                margin: 0 auto;
            }
            #main_featured_themes_page {
                font-family: Oswald;
            }
            #main_featured_themes_page #featured-themes-list li  .title  .heading {
                display: block;
                position: relative;
                font-size: 17px;
                color: #666666;
                margin: 13px 0px 13px 0px;
                text-transform: uppercase;
            }
            #main_featured_themes_page #featured-themes-list li  .title  p {
                font-size:14px;
                color:#444;
                margin-left:20px;
            }
            #main_featured_themes_page #featured-themes-list li  .description {
                height:130px;
                width: 90%;
                margin: 0 auto;
            }
            #main_featured_themes_page #featured-themes-list li  .description  p {
                text-align: center;
                width: 100%;
                color: #666666;
                font-family: "Open Sans",sans-serif;
                font-size: 14px;
            }
            #main_featured_themes_page #featured-themes-list li .links {
                border-top: 1px solid #d8d8d8;
                width: 90%;
                margin: 0 auto;
                font-size: 14px;
                line-height: 40px;
                font-weight: bolder;
                text-align: center;
                padding-top: 9px;
                padding-bottom: 12px;
            }
            #main_featured_themes_page .page_header h1 {
                margin: 0px;
                font-family: Segoe UI;
                padding-bottom: 15px;
                color: rgb(111, 111, 111);
                font-size: 24px;
                text-align:center;
            }
            #main_featured_themes_page .page_header {
                height: 40px;
                padding: 22px 0px 0px 0px;
                margin-bottom: 15px;
                /*border-bottom: rgb(111, 111, 111) solid 1px;*/
            }
            #main_featured_themes_page #featured-themes-list li a {
                outline: none;
                line-height: 29px;
                text-decoration: none;
                color: #134d68;
                font-family: "Open Sans",sans-serif;
                text-shadow: 1px 0;
                display: inline-block;
                font-size: 15px;
            }
            #main_featured_themes_page #featured-themes-list li a.demo {
                color: #ffffff;
                background: #F47629;
                border-radius: 3px;
                width: 76px;
                text-align:center;
                margin-right: 12px;
            }
            #main_featured_themes_page #featured-themes-list li a.download {
                padding-right: 30px;
                background:url(<?php echo $this->image_url; ?>down.png) no-repeat right;
            }
            #main_featured_themes_page .featured_header{
                background: #11465F;
                border-right: 3px solid #E5E5E5;
                border-bottom: 3px solid #E5E5E5;
                position: relative;
                padding: 20px 0;
            }
            #main_featured_themes_page .featured_header .try-now {
                text-align: center;
            }
            #main_featured_themes_page .featured_header .try-now span {
                display: inline-block;
                padding: 7px 16px;
                background: #F47629;
                border-radius: 10px;
                color: #ffffff;
                font-size: 23px;
            }
            #main_featured_themes_page .featured_container {
                position: relative;
                width: 90%;
                margin: 15px auto 0px auto;
            }
            #main_featured_themes_page .featured_container .old_price{
                color: rgba(180, 180, 180, 0.3);
                text-decoration: line-through;
                font-family: Oswald;
            }
            #main_featured_themes_page .featured_container .get_themes{
                color: #FFFFFF;
                height: 85px;
                margin: 0;
                background-size: 95% 100%;
                background-position: center;
                line-height: 60px;
                font-size: 45px;
                text-align: center;
                letter-spacing: 3px;
            }
            #main_featured_themes_page .featured_header h1{
                font-size: 45px;
                text-align: center;
                color: #ffffff;
                letter-spacing: 3px;
                line-height: 10px;
            }
            #main_featured_themes_page .featured_header a{
                text-decoration: none;
            }
            @media screen and (max-width: 1035px) {
                #main_featured_themes_page .featured_header h1{
                    font-size: 37px;
                    line-height: 0;
                }
            }
            @media screen and (max-width: 835px) {
                #main_featured_themes_page .get_themes span{
                    display: none;
                }
            }
            @media screen and (max-width: 435px) {
                #main_featured_themes_page .featured_header h1 {
                    font-size: 20px;
                    line-height: 17px;
                }
            }
        </style>

        <?php
        $WDWThemes = array(
            "business_elite" => array(
                "title" => "Business Elite",
                "description" => __("Business Elite is a robust parallax theme for business websites. The theme uses smooth transitions and many functional sections.",$this->lang_slug),
                "link" => "business-elite.html",
                "demo" => "theme-businesselite",
                "image" => "business_elite.jpg"
            ),
            "portfolio" => array(
                "title" => "Portfolio Gallery",
                "description" => __("Portfolio Gallery helps to display images using various color schemes and layouts combined with elegant fonts and content parts.",$this->lang_slug),
                "link" => "portfolio-gallery.html",
                "demo" => "theme-portfoliogallery",
                "image" => "portfolio_gallery.jpg"
            ),
            "sauron" => array(
                "title" => "Sauron",
                "description" => __("Sauron is a multipurpose parallax theme, which uses multiple interactive sections designed for the client-engagement.",$this->lang_slug),
                "link" => "sauron.html",
                "demo" => "theme-sauron",
                "image" => "sauron.jpg"
            ),
            "business_world" => array(
                "title" => "Business World",
                "description" => __("Business World is an innovative WordPress theme great for Business websites.",$this->lang_slug),
                "link" => "business-world.html",
                "demo" => "theme-businessworld",
                "image" => "business_world.jpg"
            ),
            "best_magazine" => array(
                "title" => "Best Magazine",
                "description" => __("Best Magazine is an ultimate selection when you are dealing with multi-category news websites.",$this->lang_slug),
                "link" => "best-magazine.html",
                "demo" => "theme-bestmagazine",
                "image" => "best_magazine.jpg"
            ),
            "magazine" => array(
                "title" => "News Magazine",
                "description" => __("Magazine theme is a perfect solution when creating news and informational websites. It comes with a wide range of layout options.",$this->lang_slug),
                "link" => "news-magazine.html",
                "demo" => "theme-newsmagazine",
                "image" => "news_magazine.jpg"
            )
        );
        ?>
        <div id="main_featured_themes_page">
            <div class="featured_container">
                <div class="page_header">
                    <h1><?php echo __("Featured Themes",$this->lang_slug); ?></h1>
                </div>
                <div class="featured_header">
                    <a target="_blank" href="https://web-dorado.com/wordpress-themes.html?source=<?php echo $this->slug; ?>">
                        <h1><?php echo __("WORDPRESS THEMES",$this->lang_slug); ?></h1>
                        <h2 class="get_themes"><?php echo __("ALL FOR $40 ONLY ",$this->lang_slug); ?><span>- <?php echo __("SAVE 80%",$this->lang_slug); ?></span></h2>
                        <div class="try-now">
                            <span><?php echo __("TRY NOW",$this->lang_slug); ?></span>
                        </div>
                    </a>
                </div>
                <ul id="featured-themes-list">
                    <?php foreach($WDWThemes as $key=>$WDWTheme) : ?>
                        <li class="<?php echo $key; ?>">
                            <div class="theme_img">
                                <img src="<?php echo $this->image_url . $WDWTheme["image"]; ?>">
                            </div>
                            <div class="title">
                                <h3 class="heading"><?php echo $WDWTheme["title"]; ?></h3>
                            </div>
                            <div class="description">
                                <p><?php echo $WDWTheme["description"]; ?></p>
                            </div>
                            <div class="links">
                                <a target="_blank" href="<?php echo $this->demo_url . $WDWTheme["demo"]."?source=".$this->slug; ?>" class="demo"><?php echo __("Demo",$this->lang_slug); ?></a>
                                <a target="_blank" href="<?php echo $this->site_url . $WDWTheme["link"]."?source=".$this->slug; ?>" class="download"><?php echo __("Free Download",$this->lang_slug); ?></a>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    <?php }

    ////////////////////////////////////////////////////////////////////////////////////////
    // Getters & Setters                                                                  //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Private Methods                                                                    //
    ////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////
    // Listeners                                                                          //
    ////////////////////////////////////////////////////////////////////////////////////////
}