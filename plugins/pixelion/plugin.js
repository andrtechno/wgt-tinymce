tinymce.PluginManager.add('pixelion', function (editor, url) {
    console.log('load');
    editor.addButton('pixelion', {
        //text: 'My button',
        icon: 'logo',
        tooltip: 'Pixelion',

        onclick: function() {
            // Open window
            editor.windowManager.open({
                title: 'Pixelion plugin',
               // width: 500,
                //height: 240,
                body: [
                    {type: 'selectbox', name: 'title', label: 'Title','items':[{ads:'dsa'}]},
                    {type: 'textbox', name: 'title2', label: 'Title2'}
                ],
                onsubmit: function(e) {
                    // Insert content when the window form is submitted
                    editor.insertContent('Title: ' + e.data.title);
                }


            });

            /*editor.windowManager.confirm("Do you want to do something", function(s) {
                if (s)
                    editor.windowManager.alert("Ok");
                else
                    editor.windowManager.alert("Cancel");
            });*/
        }
    });
});