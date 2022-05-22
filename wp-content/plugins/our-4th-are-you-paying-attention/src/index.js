import "./index.scss"
import { TextControl, Flex, FlexBlock, FlexItem, Button, Icon, PanelBody, PanelRow, ColorPicker } from "@wordpress/components"
import { InspectorControls } from "@wordpress/block-editor" // we did not install this @wordpress/block-editor but wordpress package browser search for us 
import {ChromePicker} from "react-color"

// This came from the package of @wordpress/scripts so it is not necessary to import React
// https://developer.wordpress.org/block-editor/reference-guides/packages/packages-components/
//https://developer.wordpress.org/block-editor/reference-guides/components/icon/

(function () {
    let locked = false

    wp.data.subscribe(function () {
        const results = wp.data.select("core/block-editor").getBlocks().filter(function (block) {
            return block.name == "ourplugin/are-you-paying-attention" && block.attributes.correctAnswer == undefined
        })

        if (results.length && locked == false) {
            locked = true
            wp.data.dispatch("core/editor").lockPostSaving("noanswer")
        }

        if (!results.length && locked) {
            locked = false
            wp.data.dispatch("core/editor").unlockPostSaving("noanswer")
        }
    })
})()

wp.blocks.registerBlockType("ourplugin/are-you-paying-attention", {
    title: "Are You Paying Attention?",
    icon: "smiley",
    category: "common",
    attributes: {
        question: { type: "string" },
        answers: { type: "array", default: [""] },
        correctAnswer: { type: "number", default: undefined },
        bgColor: { type: "string", default: "#EBEBEB" }
    },
    edit: EditComponent,
    save: (props) => {
        return null
    }
})

// In React we use camel case at the beginning for functions 

function EditComponent(props) {
    // function updateSkyColor(event) {
    //     props.setAttributes({ skyColor: event.target.value })
    // }

    // function updateGrassColor(event) {
    //     props.setAttributes({ grassColor: event.target.value })
    // }

    function updateQuestion(value) {
        // Instead event parameter like the other functions with wordpress components calling this function, whatever we want 
        props.setAttributes({ question: value })

    }

    function deleteAnswer(indexToDelete) {
        const newAnswers = props.attributes.answers.filter((x, index) => {
            return index != indexToDelete
        })
        props.setAttributes({ answers: newAnswers })

        if (indexToDelete == props.attributes.correctAnswer) {
            // is this is true 
            props.setAttributes({ correctAnswer: undefined })
            //This is if we delete the row with the full yellow star, then put back undefined the all row with thi empty star
        }
    }
    function markAsCorrect(index) {
        props.setAttributes({ correctAnswer: index })
    }
    return (
        /* <input type="text" placeholder="sky color" value={props.attributes.skyColor} onChange={updateSkyColor} />
         <input type="text" placeholder="grass color" value={props.attributes.grassColor} onChange={updateGrassColor} /> 

         /* Instead the previous code we can use native elements from wordpress  like TextControl*/

        /* Start using wordpress Components  
         https://developer.wordpress.org/block-editor/reference-guides/packages/packages-components/
         */
        <div className="paying-attention-edit-block" style={{ backgroundColor: props.attributes.bgColor }}>
            <InspectorControls >
                <PanelBody title="Background Color">
                    <PanelRow>
                        {/* Hello  */}
                        {/* <ColorPicker color={props.attributes.bgColor} onChangeComplete={(x) => props.setAttributes({ bgColor: x.hex })} /> this is using the default wordpress picker */}
                        <ChromePicker color={props.attributes.bgColor} onChangeComplete={(x) => props.setAttributes({ bgColor: x.hex })} disableAlpha={true}/>
                    </PanelRow>
                </PanelBody>
            </InspectorControls>
            <TextControl label="Question:" value={props.attributes.question} onChange={updateQuestion} style={{ fontSize: "20px" }} />
            <p style={{ fontSize: "13px", margin: "20px 0 8px 0" }}>Answers:</p>
            {props.attributes.answers.map((answer, index) => {
                return (
                    <Flex>
                        <FlexBlock>
                            <TextControl value={answer} onChange={(newValue) => {
                                const newAnswers = props.attributes.answers.concat([]);
                                newAnswers[index] = newValue
                                props.setAttributes({ answers: newAnswers })

                            }} />
                        </FlexBlock>
                        <FlexItem>
                            <Button onClick={() => markAsCorrect(index)}>
                                <Icon className="mark-as-correct" icon={props.attributes.correctAnswer == index ? "star-filled" : "star-empty"} />
                            </Button>
                        </FlexItem>
                        <FlexItem>
                            <Button isLink className="attention-delete" onClick={(() => deleteAnswer(index))}>Delete</Button>
                        </FlexItem>
                    </Flex>
                )
            })}
            <Button isPrimary onClick={() => {
                props.setAttributes({ answers: props.attributes.answers.concat([""]) })
            }}>Add another answer</Button>
            {/* isPrimary is to add styles like boostrap  */}
        </div>
    )
}