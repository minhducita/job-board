{extends file='MobileTemplates/master.tpl'}
{block name='main-content'}
    <div class="content">
        <section class="main">
            <div class="detail-page">
                <h2>Contact　お問い合わせ</h2>
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            {if $page.has_form == '1'}
                            {if !empty($errors)}
                                <div class="validation-failure">
                                    {$errors.contact_error}
                                </div>
                            {elseif isset($smarty.session.contact_msg_sent) && $smarty.session.contact_msg_sent == 1}
                                <div class="apply-status-ok">
                                    {$page.form_message}
                                </div>
                            {/if}
                            {$page.content}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="frmContact">
                                {if $smarty.const.IS_MOBILE}{$mobile_location = 'mobile/'}{else}{$mobile_location=''}{/if}
                                <form method="post" action="{$BASE_URL}{$mobile_location}{$page.url}/">
                                    <div class="form-group">
                                        <label for="contact_name" class="nopadding-left">{$translations.contact.name_label} <span class="red">(required)</span> :</label>
                                        <input type="text" name="contact_name" id="contact_name"  class="form-control" maxlength="50" size="30" value="{if !empty($smarty.post.contact_name)}{$smarty.post.contact_name}{/if}" />
                                        <p class="block-error">{if !empty($errors.contact_name)}{$translations.contact.name_error}{/if}</p>

                                    </div>
                                    <div class="form-group">
                                        <label for="contact_email" class="nopadding-left">{$translations.contact.email_label} <span class="red">(required)</span> :</label>
                                        <input type="text" name="contact_email" id="contact_email" class="form-control" maxlength="50" size="30" value="{if !empty($smarty.post.contact_email)}{$smarty.post.contact_email}{/if}" />
                                        <p class="block-error">{if !empty($errors.contact_name)}{$translations.contact.email_error}{/if}</p>
                                    </div>
                                    <div class="form-group">
                                        <label for="contact_msg">{$translations.contact.message_label} <span class="red">(required)</span> :</label>
                                        <textarea name="contact_msg" id="contact_msg" class="form-control" cols="41" rows="8">{if !empty($smarty.post.contact_msg)}{$smarty.post.contact_msg}{/if}</textarea>
                                        <p class="block-error">{if !empty($errors.contact_msg)}{$translations.contact.msg_error}{/if}</p>
                                    </div>
                                    <div class="form-group mb0">
                                        {if $ENABLE_RECAPTCHA}
                                            <br /><br />
                                            <label for="recaptcha_response_field">{$translations.captcha.captcha_title} <span class="red">(required)</span> :</label><br />
                                        {literal}
                                            <script type="text/javascript">
                                                var RecaptchaOptions = {
                                                    theme : 'custom',
                                                    custom_theme_widget: 'responsive_recaptcha'
                                                };
                                            </script>
                                        {/literal}
                                            <div class="capcha">
                                                {$the_captcha}
                                            </div>
                                            <p class="block-error">{if !empty($errors.captcha)}{$translations.contact.captcha}{/if}</p>
                                        {/if}

                                        <p class="mb0">
                                            <input type="submit" name="submit" class="btn btnSend bg4cb3ad" id="submit" value="{$translations.contact.submit}" />
                                        </p>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                    {/if}
                </div>
            </div>
        </section>
    </div>
    {if $page.has_form == '1'}
    {literal}
        <script type="text/javascript">
            $(document).ready(function()
            {
                $("#apply-online").validate({
                    rules: {
                        contact_name: { required: true },
                        contact_email: { required: true, email: true },
                        contact_msg: { required: true }
                    },
                    messages: {
                        contact_name: ' <img src="{/literal}{$BASE_URL}_templates/{$THEME}/{literal}img/icon-delete.png" alt="" />',
                        contact_email: ' <img src="{/literal}{$BASE_URL}_templates/{$THEME}/{literal}img/icon-delete.png" alt="" />',
                        contact_msg: ' <img src="{/literal}{$BASE_URL}_templates/{$THEME}/{literal}img/icon-delete.png" alt="" />'
                    }
                });
            });
        </script>
    {/literal}
    {/if}
{/block}