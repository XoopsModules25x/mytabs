What is mytabs Module (v2.2) ?
======================

With this Xoops module, your can create blocks with several tabs an blocks inside.

The module can :
. Create any blocks you want (just clone the original)
. Create any pages (holders for tabs) you want so you can choose in the block what page to show
. Create any tabs you want per page 
. Create any blocks you want per tabs 
. Set group view permissions per block/page, tab and block
. Set time based tabs and blocks (auto-expiring)
. Set blocks side: left, center or right.
. Choose from 9 different page/block layouts
. Use how many blocks you want in the same page or not (just clone and set them)
. Many other goodies like cache, position, scroll, width, Show/hide other divs, link tab to url, onmouseover selection, etc


Requirements
====================

Requires xoops 2.4.x and php5


How to install mytabs
====================

Copy mytabs folder into the /modules directory of your website. 
Then log in to your site as administrator, go to System Admin > Modules, look for the mytabs
icon in the list of uninstalled modules and click in the install icon. 
Follow the directions in the screen and you'll be ready to go.


Upgrading from 2.1
====================

Remove all mytabs files and upload new ones. You do not need to remove or update menus folder. 


Tips
====================

You can create your own style.css for tabs. 
Create a folder under menus with the class name you use inside your style.css (check how the other ones are done)
Upload your style.css and images to the menu folder you've created and it will be available for selection in mytabs blocks!

The 'slate' menu is available in other colors. Check it out.

------

To avoid tabs from scrolling set delay to 0 inside your block.

------

You can create html custom blocks and make them interact with each tab.
Ex of a custom block:
<div id="mydiv" style="display: none;">My tip number1</div>
<div id="mydiv2" style="display: none;">My hidden links</div>

And then set 'Reveal ID' inside the tabs edit form
for tab1 : my div
for tab2 : mydiv2 

You can expand/contract more than one div, just separate the divs ids with a comma

for tab 3 : my div, mydiv2

------

You can also add a link to a tab.
Just set 'Links to' with the complete URL
Ex: http://www.anothersite.com/register.php 

------

You can use Mytabs as a menu!
Set your block height to 0 and create tabs without blocks.
Using the 'Link To' option you can easily make your menu.
You do not need to enter all the complete link
ex:

index.php
modules/news
viewpmsg.php

You can use {user_id} in your link. It will retrieve the Id of the user seeing the page
ex:

userinfo?uid={user_id}

You can also customize the name of the link for display private messages info

In the tab title just add
{pm_new}
{pm_readed}
{pm_total}

ex: 

title = Inbox {pm_new}
Link to = viewpmsg.php

------

You can hide the tabs in the block settings. This is useful if you are using delay>0 (switching tabs). This 
way you create a slide show for your photos, partners, publicity, etc where the name of the tab and the 
ability to stop the switching is not relevant.


-----

You can make a link to toggle a specific tab. 
Let큦 say you want xoops.org to open the "Install" tab that is in the front page.
First you have to get the id of the block by viewing the source code. 
You will find something link this in xoops.org:

tabscontents_1215070896

Then you get the index of the tab you want to display. First tab = 0, second tab = 1, etc..., 'Install' tab = 5
Making the link is as simple as this:

http://www.xoops.org/index.php?tabscontents_1215070896=5


Limitations
========

Although you can use a mytabs block(let큦 call it mytabsblock1) inside a mytabspage(let큦 call it mytabspage1), using mytabspage1 inside mytabsblock1 is impossible as it results in an endless loop. Because of this, a check was added when rendering the blocks to prevent conflicting blocks to display. 

This means that you are able to add conflicting blocks but they are ignored and will not show in your page.

However it can be useful to use a mytabsblock2 that contains a mytabspage2 that contains a mytabsblock3(clone)  in the same layout page that contains a mytabsblock3(original).

In a normal situation only one of the mytabsblocks will display because the other will be blocked by mytabs 'fool proof system'.
To bypass this situation you have to edit the original mytabsblock3 and change the 'uniqueid' field.

Yeah, it sounds more like a 'fool system'. I큞l try to make it better.


Feedback
========

Please use http://www.xuups.com (xoops user utilities)