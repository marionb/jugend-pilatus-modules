
(function($)
    {
    var result = null;
    $(document).ready(function()
        {
        $(".link2download").click(function(event)
            {
            event.preventDefault();
            var getPathToElement = $(this).attr('href');
            getPathToElement.toString();
            $.ajax({
                type: "POST",
                url:  "SimpleAjax.php",
                data: { type: "countDownload", path: encodeURIComponent(getPathToElement) },
                success: function(result)
                    {
                        if(result) {
                            window.location.href = getPathToElement;
                        }
                    }
                });
            });
        });
    })(jQuery);
