jQuery(document).ready(function()
{
    function activeTab(obj)
    {
        jQuery('.tab-category ul li').removeClass('active');
        jQuery(obj).addClass('active');
        var id = jQuery(obj).find('a').attr('href');
        jQuery('.ul-cate').hide();
        jQuery(id).show();
    }

    jQuery('.tab-category li').click(function(){
        activeTab(this);
        return false;
    });

    activeTab(jQuery('.tab-category li:first-child'));
});
