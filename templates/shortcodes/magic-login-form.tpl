<div class="row amc-spark-magic-login-wrapper">
    <div class="col-md-12">
        <h3>Magischer Login</h3>
        <div id="amc-spark-success-message-wrapper" style="display: none; margin-bottom: 15px;">
            <div class="alert alert-success">
                <strong>
                    <i class="fa fa-check"></i>
                </strong>
                <span id="amc-spark-success-message-content"></span>
            </div>
        </div>

        <div id="amc-spark-error-message-wrapper" style="display: none; margin-bottom: 15px;">
            <div class="alert alert-danger">
                <strong>
                    <i class="fa fa-exclamation-triangle"></i>
                </strong>
                <span id="amc-spark-error-message-content"></span>
            </div>
        </div>

        <form id="amc-spark-magic-login">
            <input type="hidden" name="action" value="amc_send_magic_mail">
            <input type="hidden" name="magic-redirect" value="{$current_url}">
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon" id="email-addon">
                        <i class="fa fa-envelope"></i>
                    </span>
                    <input name="user"
                           required
                           class="form-control"
                           type="email"
                           autocomplete="email"
                           aria-describedby="email-addon"
                           placeholder="E-Mail Adresse">
                </div>

            </div>
            <input type="submit"
                   class="btn btn-info btn-block"
                   id="amc-spark-magic-login-submit">
        </form>
    </div>
</div>
<script>
    jQuery(function() {
        var form = jQuery('#amc-spark-magic-login'),
            submitBtn = jQuery('#amc-spark-magic-login-submit'),
            successMsgWrapper = jQuery('#amc-spark-success-message-wrapper'),
            successMsg = jQuery('#amc-spark-success-message-content'),
            errorMsgWrapper = jQuery('#amc-spark-error-message-wrapper'),
            errorMsg = jQuery('#amc-spark-error-message-content');
        form.on('submit', function(event) {
            event.preventDefault();
            submitBtn.prop('disabled', true);
            jQuery.post('/wp-admin/admin-ajax.php', form.serialize(), function(data) {
                if(data.success) {
                    successMsg.html(data.data);
                    successMsgWrapper.show();
                    errorMsgWrapper.hide();
                } else {
                    errorMsg.html(data.data);
                    successMsgWrapper.hide();
                    errorMsgWrapper.show();
                }
                submitBtn.prop('disabled', false);
            });
        });
    });
</script>