
<div class="form-group">
    <label class="text-dark"
        for="promo_text">{{ __('adminstaticword.FacebookChatBubble') }}:</label>
    <input form="settingsform" value="{{ $setting->chat_bubble }}" name="chat_bubble"
        placeholder="https://app.respond.io/facebook/chat/plugin/XXXX/XXXXXXXXXX" type="url"
        class="{{ $errors->has('chat_bubble') ? ' is-invalid' : '' }} form-control">
    <small>{{ __('Facebook Bubble Chat will not work on localhost (eg. xampp & wampp)') }}</small>
    <br>
    <small><a target="__blank"
            href="https://app.respond.io/">{{ __('Get URL For Facebook Messenger Chat Bubble') }}</a></small>
</div>
<div class="form-group">
    <button type="reset" form="settingsform" class="btn btn-danger-rgba mr-1"><i class="fa fa-ban"></i>
        {{ __("Reset")}}</button>
    <button type="submit" form="settingsform" class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
        {{ __("Update")}}</button>
</div>