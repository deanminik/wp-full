import "./index.scss"
import {TextControl, Flex, FlexBlock, FlexItem, Button, Icon} from "@wordpress/components"

// This came from the package of @wordpress/scripts so it is not necessary to import React
// https://developer.wordpress.org/block-editor/reference-guides/packages/packages-components/

wp.blocks.registerBlockType("ourplugin/are-you-paying-attention", {
    title: "Are You Paying Attention?",
    icon: "smiley",
    category: "common",
    attributes: {
        skyColor: { type: "string" },
        grassColor: { type: "string" }
    },
    edit: EditComponent,
    save: (props) => {
        return null
    }
})

// In React we use camel case at the beginning for functions 

function EditComponent(props) {
    function updateSkyColor(event) {
        props.setAttributes({ skyColor: event.target.value })
    }

    function updateGrassColor(event) {
        props.setAttributes({ grassColor: event.target.value })
    }
    return (
        /* <input type="text" placeholder="sky color" value={props.attributes.skyColor} onChange={updateSkyColor} />
         <input type="text" placeholder="grass color" value={props.attributes.grassColor} onChange={updateGrassColor} /> 

         /* Instead the previous code we can use native elements from wordpress  like TextControl*/

        /* Start using wordpress Components  
         https://developer.wordpress.org/block-editor/reference-guides/packages/packages-components/
         */
        <div className="paying-attention-edit-block">
            <TextControl label="Question:" />
            <p>Answers:</p>
            <Flex>
                <FlexBlock>
                    <TextControl />
                </FlexBlock>
                <FlexItem>
                    <Button>
                        <Icon icon="star-empty" />
                    </Button>
                </FlexItem>
                <FlexItem>
                    <Button>Delete</Button>
                </FlexItem>
            </Flex>
        </div>
    )
}