wp.blocks.registerBlockType("ourplugin/are-you-paying-attention", {
    title: "Are You Paying Attention?",
    icon: "smiley",
    category: "common",
    edit: () => {
        // argument 1 -> the tag
        // argument 2 -> attribute 
        // argument 3 -> the content inside the tag 

        //createElement -> this is the way wordpress create html content 
        return wp.element.createElement("h3", null, "Hello, this is from the admin editor screen");
    },
    save: () => {
        return wp.element.createElement("h1", null, "This is the FrontEnd");
    }


});