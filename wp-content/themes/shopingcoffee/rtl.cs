/*
Theme Name: Twenty Ten
*/


/*
RTL Basics
*/


body {
	direction:rtl;
	unicode-bidi:embed;
}


/*
LAYOUT: Two-Column (Right)
DESCRIPTION: Two-column fixed layout with one sidebar right of content
*/

#container {
	float: right;
	margin: 0 0 0 -240px;
}
#content {
	margin: 0 20px 36px 280px;
}
#primary,
#secondary {
	float: left;
}
#secondary {
	clear: left;
}


/* =Fonts
-------------------------------------------------------------- */
body,
input,
textarea,
.page-title span,
.pingback a.url,
h3#comments-title,
h3#reply-title,
#access .menu,
#access div.menu ul,
#cancel-comment-reply-link,
.form-allowed-tags,
#site-info,
#site-title,
#wp-calendar,
.comment-meta,
.comment-body tr th,
.comment-body thead th,
.entry-content label,
.entry-content tr th,
.entry-content thead th,
.entry-meta,
.entry-title,
.entry-utility,
#respond label,
.navigation,
.page-title,
.pingback p,
.reply,
.widget-title,
input[type=submit] {
	font-family: Arial, Tahoma, sans-serif;
}

/* =Structure
-------------------------------------------------------------- */

/* The main theme structure */
#footer-widget-area .widget-area {
	float: right;
	margin-left: 20px;
	margin-right: 0;
}
#footer-widget-area #fourth {
	margin-left: 0;
}
#site-info {
	float: right;
}
#site-generator {
	float: left;
}


/* =Global Elements
-------------------------------------------------------------- */

/* Text elements */
ul {
	margin: 0 1.5em 18px 0;
}
blockquote {
	font-style: normal;
}

/* Text meant only for screen readers */
.screen-reader-text {
	left: auto;
	text-indent:-9000px;
	overflow:hidden;
}


/* =Header
-------------------------------------------------------------- */

#site-title {
	float: right;
}
#site-description {
	clear: left;
	float: left;
	font-style: normal;
}

/* =Menu
-------------------------------------------------------------- */

#access {
	float:right;
}

#access .menu-header,
div.menu {
    margin-right: 12px;
    margin-left: 0;
}

#access .menu-header li,
div.menu li{
	float:right;
}

#access ul ul {
	left:auto;
	right:0;
	float:right;
}
#access ul ul ul {
	left:auto;
	right:100%;
}

/* =Content
-------------------------------------------------------------- */

#content table {
	text-align: right;
	margin: 0 0 24px -1px;
}
.page-title span {
	font-style:normal;
}
.entry-title,
.entry-meta {
	clear: right;
	float: right;
	margin-left: 68px;
	margin-right: 0;
}

.entry-content input.file,
.entry-content input.button {
	margin-left: 24px;
	margin-right:0;
}
.entry-content blockquote.left {
	float: right;
	margin-right: 0;
	margin-left: 24px;
	text-align: left;
}
.entry-content blockquote.right {
	float: left;
	margin-right: 24px;
	margin-left: 0;
	text-align: right;
}
#entry-author-info #author-avatar {
	float: right;
	margin: 0 0 0 -104px;
}
#entry-author-info #author-description {
	float: right;
	margin: 0 104px 0 0;
}

/* Gallery listing
-------------------------------------------------------------- */

.category-gallery .gallery-thumb {
	float: right;
 	margin-left:20px;
	margin-right:0;
}


/* Images
-------------------------------------------------------------- */

#content .gallery .gallery-caption {
	margin-right: 0;
}

#content .gallery .gallery-item {
	float: right;
}

/* =Navigation
-------------------------------------------------------------- */
.nav-previous {
	float: right;
}
.nav-next {
	float: left;
	text-align:left;
}

/* =Comments
-------------------------------------------------------------- */

.commentlist li.comment {
	padding: 0 56px 0 0;
}
.commentlist .avatar {
	right: 0;
	left: auto;
}
.comment-author .says, #comments .pingback .url  {
	font-style: normal;
}

/* Comments form */
.children #respond {
	margin: 0 0 0 48px;
}

/* =Widget Areas
-------------------------------------------------------------- */

.widget-area ul {
	margin-right: 0;
}
.widget-area ul ul {
	margin-right: 1.3em;
	margin-left: 0;
}
#wp-calendar caption {
	text-align: right;
}
#wp-calendar tfoot #next {
	text-align: left;
}

/* Main sidebars */
#main .widget-area ul {
	margin-right: 0;
	padding: 0 0 0 20px;
}
#main .widget-area ul ul {
	margin-right: 1.3em;
	margin-left: 0;
}

/* =Footer
-------------------------------------------------------------- */
#site-generator {
	font-style:normal;
}
#site-generator a {
	background-position: right center;
	padding-right: 20px;
	padding-left: 0;
}

.width25 {
	width: 25%;
}