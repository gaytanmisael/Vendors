$(document).ready(function(){
    
    // Clear Value on fields
    $('.username, .first_name, .password, .last_name, .email_address').each(function() {
        var default_value = this.value;
        $(this).focus(function(){
            if(this.value == default_value) {
                this.value = '';
            }
        });

        $(this).blur(function(){
            if(this.value == '') {
                this.value = default_value;
            }
        });
    });
    
    // FancyBox for ads with IO - big_pic
    $(".big_pic").fancybox();
});