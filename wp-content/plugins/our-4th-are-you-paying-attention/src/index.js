wp.blocks.registerBlockType("ourplugin/are-you-paying-attention", {
    title: "Are You Paying Attention?",
    icon: "smiley",
    category: "common",
    edit: () => {
        return (
           <div>
               <p>Hello, this is a paragraph.</p>
               <h4>Hi there gentes </h4>
           </div>
        )
    },
    save: () => {
        return (
            <>
            <h3> h3 On the frontEnd</h3>
            <h4> h4 On the frontEnd</h4>
            </>
        )
    }


});