import "./index.scss"
import { TextControl, Flex, FlexBlock, FlexItem, Button, Icon } from "@wordpress/components"

// This came from the package of @wordpress/scripts so it is not necessary to import React
// https://developer.wordpress.org/block-editor/reference-guides/packages/packages-components/

wp.blocks.registerBlockType("ourplugin/are-you-paying-attention", {
    title: "Are You Paying Attention?",
    icon: "smiley",
    category: "common",
    attributes: {
        question: { type: "string" },
        answers: { type: "array", default: ["red", "blue"] }
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
    }
    return (
        /* <input type="text" placeholder="sky color" value={props.attributes.skyColor} onChange={updateSkyColor} />
         <input type="text" placeholder="grass color" value={props.attributes.grassColor} onChange={updateGrassColor} /> 

         /* Instead the previous code we can use native elements from wordpress  like TextControl*/

        /* Start using wordpress Components  
         https://developer.wordpress.org/block-editor/reference-guides/packages/packages-components/
         */
        <div className="paying-attention-edit-block">
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
                            <Button>
                                <Icon className="mark-as-correct" icon="star-empty" />
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