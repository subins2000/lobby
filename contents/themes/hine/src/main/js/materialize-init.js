lobby.load(function(){
  $('[title]').each(function(){
    $(this).attr("data-tooltip", $(this).attr("title"));
    $(this).tooltip({delay: 50});
    $(this).attr("title", "");
  });
});
