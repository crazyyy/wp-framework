
<div class="sucuriscan-overlay"></div>

<div class="sucuriscan-modal">
    <div class="sucuriscan-modal-outside %%SUCURI.CssClass%%">

        <div class="sucuriscan-modal-header">
            <a href="#" class="sucuriscan-modal-close">&times;</a>
            <h3 class="sucuriscan-modal-title">%%SUCURI.Title%%</h3>
        </div>

        <div class="sucuriscan-modal-inside">
            %%SUCURI.Content%%
        </div>

    </div>
</div>

<script type="text/javascript">
jQuery(function($){
    $('.sucuriscan-overlay, .sucuriscan-modal-close').on('click', function(e){
        e.preventDefault();
        $('.sucuriscan-overlay, .sucuriscan-modal').remove();
    });
});
</script>
