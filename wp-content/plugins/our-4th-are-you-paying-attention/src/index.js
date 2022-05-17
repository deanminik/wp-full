wp.blocks.registerBlockType("ourplugin/are-you-paying-attention", {
    title: "Are You Paying Attention?",
    icon: "smiley",
    category: "common",
    attributes: {
        skyColor: { type: "string" },
        grassColor: { type: "string" }
    },
    edit: (props) => {
        function updateSkyColor(event) {
            props.setAttributes({ skyColor: event.target.value })
        }

        function updateGrassColor(event) {
            props.setAttributes({ grassColor: event.target.value })
        }
        //   skyColor: { type: "string", source:"text", selector:".skyColor"},
        //   grassColor: { type: "string", source:"text", selector:".grassColor" }
        return (
            <div>
                <input type="text" placeholder="sky color" value={props.attributes.skyColor} onChange={updateSkyColor} />
                <input type="text" placeholder="grass color" value={props.attributes.grassColor} onChange={updateGrassColor} />
            </div>
        )
    },
    save: (props) => {
        return (
            <p>Today the sky is <span className="skyColor">{props.attributes.skyColor}</span> and the grass is <span className="grassColor">{props.attributes.grassColor}</span>.</p>
        )
    }
})
