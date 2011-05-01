$(document).ready(function(){
    $(".pointsList").sortable({
        axis        : 'y',                // Only vertical movements allowed
        containment    : 'window',            // Constrained by the window
        update        : function(){        // The function is called after the todos are rearranged
        
            // The toArray method returns an array with the ids of the todos
            var arr = $(".pointsList").sortable('toArray');
            
            // Striping the todo- prefix of the ids:
            
            arr = $.map(arr,function(val,key){
                return val.replace('points-','');
            });
            
            // Saving with AJAX
            $.get('/points/change-order',{format: 'json', positions:arr});
        },
        
        /* Opera fix: */
        
        stop: function(e,ui) {
            ui.item.css({'top':'0','left':'0'});
        }
    });
    
    // A global variable, holding a jQuery object 
    // containing the current todo item:
    
    var currentTODO;
    
    // Configuring the delete confirmation dialog
    $("#dialog-confirm").dialog({
        resizable: false,
        height:130,
        modal: true,
        autoOpen:false,
        buttons: {
            'Delete item': function() {
                
                $.get("/points/delete",{"format":"json","id":currentTODO.data('id')},function(msg){
                    currentTODO.fadeOut('fast');
                })
                
                $(this).dialog('close');
            },
            Cancel: function() {
                $(this).dialog('close');
            }
        }
    });

    // When a double click occurs, just simulate a click on the edit button:
    $('.points').live('dblclick',function(){
        $(this).find('a.edit').click();
    });
    
    // If any link in the todo is clicked, assign
    // the todo item to the currentTODO variable for later use.

    $('.points a').live('click',function(e){
                                       
        currentTODO = $(this).closest('.points');
        currentTODO.data('id',currentTODO.attr('id').replace('points-',''));
        
        e.preventDefault();
    });

    // Listening for a click on a delete button:

    $('.points a.delete').live('click',function(){
        $("#dialog-confirm").dialog('open');
    });
    
    // Listening for a click on a edit button
    
    $('.points a.edit').live('click',function(){

        var container = currentTODO.find('.text');
        
        if(!currentTODO.data('origText'))
        {
            // Saving the current value of the ToDo so we can
            // restore it later if the user discards the changes:
            
            currentTODO.data('origText',container.text());
        }
        else
        {
            // This will block the edit button if the edit box is already open:
            return false;
        }
        
        $('<input type="text">').val(container.text()).appendTo(container.empty());
        
        // Appending the save and cancel links:
        container.append(
            '<div class="editTodo">'+
                '<a class="saveChanges" href="#">Save</a> or <a class="discardChanges" href="#">Cancel</a>'+
            '</div>'
        );
        
    });
    
    // The cancel edit link:
    
    $('.points a.discardChanges').live('click',function(){
        currentTODO.find('.text')
                    .text(currentTODO.data('origText'))
                    .end()
                    .removeData('origText');
    });
    
    // The save changes link:
    
    $('.points a.saveChanges').live('click',function(){
        var text = currentTODO.find("input[type=text]").val();
        
        $.get("ajax.php",{'action':'edit','id':currentTODO.data('id'),'text':text});
        
        currentTODO.removeData('origText')
                    .find(".text")
                    .text(text);
    });
    
    
    
    $("#dialog-form").dialog({
        resizable: false,
        height:230,
        modal: true,
        autoOpen:false,
        buttons: {
            'save': function() {
                
                var name = $("#name"), link=$("#link");
                $.get("/points/add",{'format':'json','name':name.val(),'link':link.val()},function(msg){
                    //todo append list
                    $(msg).hide().appendTo('.pointsList').fadeIn();
                })
                
                $(this).dialog('close');
            },
            Cancel: function() {
                $(this).dialog('close');
            }
        }
    });
    $('#addButton').live('click',function(){
        $("#dialog-form").dialog('open');
    });
    
    $("#login-form").dialog({
        resizable: false,
        height:230,
        modal: true,
        autoOpen:true,
        buttons: {
            'submit': function() {
                var user_name = $("#user_name"), password=$("#password");
                $.post("/auth/index",{'format':'json','user_name':user_name.val(),
                       'password':password.val()},function(msg){
                           //console.debug(msg.status);
                           if (1 == msg.status) {
                               //console.debug('close dialog');
                               $('#login-form').dialog('close');
                               // update pane
                               $.get("/points/get-list", {},function(list){
                                   //console.debug(list);
                                   $(list).hide().appendTo('.pointsList').fadeIn();
                               })
                           } else {
                               alert('wrong password or username');
                           }
                       })
            },
        },
        closeOnEscape: false,
        open: function(event, ui) { $(".ui-dialog-titlebar-close").hide(); }
    });
}); // Closing $(document).ready()

