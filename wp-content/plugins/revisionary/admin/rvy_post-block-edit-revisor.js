jQuery(document).ready(function($){$(document).on('click','button.editor-post-publish-button,button.editor-post-save-draft',function(){var RvyRedirectCheckSaveInterval=setInterval(function(){let saving=wp.data.select('core/editor').isSavingPost();if(saving){clearInterval(RvyRedirectCheckSaveInterval);var RvyRedirectCheckSaveDoneInterval=setInterval(function(){let saving=wp.data.select('core/editor').isSavingPost();if(!saving){clearInterval(RvyRedirectCheckSaveDoneInterval);let goodsave=wp.data.select('core/editor').didPostSaveRequestSucceed();if(goodsave){var redirectProp='redirectURL';if(typeof rvyObjEdit[redirectProp]!=undefined){var rurl=rvyObjEdit[redirectProp];var recipients=$('input[name="prev_cc_user[]"]:checked');if(recipients.length){var cc=recipients.map(function(){return $(this).val();}).get().join(',');rurl=rurl+'&cc='+cc;}
$(location).attr("href",rurl);}}}},50);}},10);});function RvyRecaptionButton(btnName,btnSelector,btnCaption){let node=document.querySelector(btnSelector);if(node){document.querySelector(btnSelector).innerText=`${btnCaption}`;}}
function RvySetPublishButtonCaption(caption,waitForSaveDraftButton,forceRegen,timeout){if(caption==''&&(typeof rvyObjEdit['publishCaptionCurrent']!=undefined)){caption=rvyObjEdit.publishCaptionCurrent;}else{rvyObjEdit.publishCaptionCurrent=caption;}
if(typeof waitForSaveDraftButton=='undefined'){waitForSaveDraftButton=false;}
if((!waitForSaveDraftButton||$('button.editor-post-switch-to-draft').filter(':visible').length||$('button.editor-post-save-draft').filter(':visible').length)&&$('button.editor-post-publish-button').length){RvyRecaptionButton('publish','button.editor-post-publish-button',caption);}else{if((typeof timeout=='undefined')||parseInt(timeout)<50){timeout=15000;}
var RecaptionInterval=setInterval(RvyWaitForRecaption,100);var RecaptionTimeout=setTimeout(function(){clearInterval(RvyRecaptionInterval);},parseInt(timeout));function WaitForRecaption(timeout){if(!waitForSaveDraftButton||$('button.editor-post-switch-to-draft').filter(':visible').length||$('button.editor-post-save-draft').filter(':visible').length){if($('button.editor-post-publish-button').length){clearInterval(RvyRecaptionInterval);clearTimeout(RvyRecaptionTimeout);RvyRecaptionButton('publish','button.editor-post-publish-button',caption);}else{if(waitForSaveDraftButton){clearInterval(RvyRecaptionInterval);clearTimeout(RvyRecaptionTimeout);}}}}}}
var RvyDetectPublishOptionsDivClosureInterval='';var RvyDetectPublishOptionsDiv=function(){if($('div.components-modal__header').length){clearInterval(RvyDetectPublishOptionsDivInterval);if($('span.pp-recaption-button').first()){rvyObjEdit.overrideColor=$('span.pp-recaption-button').first().css('color');}
var RvyDetectPublishOptionsClosure=function(){if(!$('div.components-modal__header').length){clearInterval(RvyDetectPublishOptionsDivClosureInterval);$('span.pp-recaption-button').hide();RvyInitInterval=setInterval(RvyInitializeBlockEditorModifications,50);RvyDetectPublishOptionsDivInterval=setInterval(RvyDetectPublishOptionsDiv,1000);}}
RvyDetectPublishOptionsDivClosureInterval=setInterval(RvyDetectPublishOptionsClosure,200);}}
var RvyDetectPublishOptionsDivInterval=setInterval(RvyDetectPublishOptionsDiv,1000);rvyObjEdit.publishCaptionCurrent=rvyObjEdit.publish;var RvyInitializeBlockEditorModifications=function(){if(($('button.editor-post-publish-button').length||$('button.editor-post-publish-panel__toggle').length)&&($('button.editor-post-switch-to-draft').length||$('button.editor-post-save-draft').length)){clearInterval(RvyInitInterval);if($('button.editor-post-publish-panel__toggle').length){if(typeof rvyObjEdit.prePublish!='undefined'&&rvyObjEdit.prePublish){RvyRecaptionButton('prePublish','button.editor-post-publish-panel__toggle',rvyObjEdit.prePublish);}
$(document).on('click','button.editor-post-publish-panel__toggle,span.pp-recaption-prepublish-button',function(){RvySetPublishButtonCaption('',false,true);});}else{RvySetPublishButtonCaption(rvyObjEdit.publish,false,true);}
$('select.editor-post-author__select').parent().hide();$('div.edit-post-post-visibility').hide();$('button.editor-post-trash').hide();$('div.components-panel div.components-panel__body').not(':first').hide();$('button.editor-post-switch-to-draft').hide();$('div.components-notice-list').hide();}}
var RvyInitInterval=setInterval(RvyInitializeBlockEditorModifications,50);var RvyHideElements=function(){var ediv='div.edit-post-sidebar ';if($(ediv+'select.editor-post-author__select:visible,'+ediv+'div.components-base-control__field input[type="checkbox"]:visible').length){$(ediv+'select.editor-post-author__select').parent().hide();$(ediv+'div.components-base-control__field input[type="checkbox"]').parent().hide();$(ediv+'div.edit-post-post-visibility').hide();$(ediv+'button.editor-post-trash').hide();$(ediv+'div.components-panel div.components-panel__body').not(':first').hide();$(ediv+'button.editor-post-switch-to-draft').hide();}}
var RvyHideInterval=setInterval(RvyHideElements,200);});