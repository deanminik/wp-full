import "./index.scss"
import { useSelect } from "@wordpress/data"
import { useState, useEffect } from "react"
import apiFetch from "@wordpress/api-fetch"

//wp.i18.__ -> this is to look in the global scope instead of"@wordpress/data" "react" or "@wordpress/api-fetch"

const __ = wp.i18n.__

wp.blocks.registerBlockType("ourplugin/featured-professor", {
  title: "Professor Callout",
  description: "Include a short description and link to a professor of your choice",
  icon: "welcome-learn-more",
  category: "common",
  attributes: {
    profId: { type: "string" }
  },
  edit: EditComponent,
  save: function () {
    return null
  }
})

function EditComponent(props) {
  const [thePreview, setThePreview] = useState("")

  useEffect(() => {
    // updateTheMeta()

    // async function go() {
    //   //wordpress tool
    //   const response = await apiFetch({
    //     path: `featuredProfessor/v1/getHTML?profId=${props.attributes.profId}`,
    //     method: "GET"
    //   })
    //   setThePreview(response)
    // }
    // go()
    if (props.attributes.profId) {
      updateTheMeta()

      async function go() {
        //wordpress tool
        const response = await apiFetch({
          path: `featuredProfessor/v1/getHTML?profId=${props.attributes.profId}`,
          method: "GET"
        })
        setThePreview(response)
      }
      go()
    }

  }, [props.attributes.profId])// useEffect is watching [props.attributes.profId] for changes, for example if someone is clicking
  //different option in the dropdown  

  useEffect(() => {
    return () => {
      updateTheMeta()
    }
  }, [])

  function updateTheMeta() {
    // Select all block types from the editor
    //const profsForMeta = wp.data.select("core/block-editor").getBlocks(); // This returns an array of all blocks, paragraph, lists etc  
    const profsForMeta = wp.data.select("core/block-editor").getBlocks().filter(x => x.name == "ourplugin/featured-professor").map(x => x.attributes.profId).filter((x, index, arr) => { return arr.indexOf(x) == index })
    //This 
    // is to bring only the data the id from our custom blocks and not duplicated id 
    //(x, index, arr using indexOf asking if anything inside your array thereis is a value like this indexOf(value)
    console.log(profsForMeta)

    wp.data.dispatch("core/editor").editPost({ meta: { featuredProfessor: profsForMeta } }) //this only save in javascript memory, not to the database 
  }

  const allProfs = useSelect(select => {
    return select("core").getEntityRecords("postType", "professor", { per_page: -1 })
  })

  // console.log(allProfs)
  /* featured-professor is our text domain from featured-professor.php */

  if (allProfs == undefined) return <p>Loading...</p>
  return (
    <div className="featured-professor-wrapper">
      <div className="professor-select-container">
        {/* We will have a select dropdown form element here. */}
        <select onChange={e => props.setAttributes({ profId: e.target.value })}>
          <option value="">{__("Select a professor", "featured-professor")}</option>

          {allProfs.map(prof => {
            return (
              <option value={prof.id} selected={props.attributes.profId == prof.id}> {prof.title.rendered}</option>
            )
          })}


        </select>
      </div>
      <div dangerouslySetInnerHTML={{ __html: thePreview }}></div>
      {/* dangerouslySetInnerHTML={{ __html: thePreview }} this is to render the content from the async response */}
    </div>
  )
}