
    //manages the hide and show of the job applications

    jQuery(document).ready(function(){
        jQuery(".panel-collapse").css('display','none');
        jQuery(".clickable").click(function(){
            var id = jQuery(this).attr('id');
            var application = "collapse-"+id;
            var applicationContainer = document.getElementById(application);
            // jQuery(".panel-collapse").css('display','none');
            // jQuery(applicationContainer).css('display','block');
            jQuery(".panel-collapse").slideUp("slow");
            jQuery(applicationContainer).slideDown();
        });
    });

