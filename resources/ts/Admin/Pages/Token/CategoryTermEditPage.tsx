import * as React from 'react'
import { useState, useEffect } from 'react'
import CategoryTermEditForm from '../../Components/Token/CategoryTermEditForm'
import TermEditPage from '../../Pages/TermEditPage'
import { PostEditPageProps } from '../../Pages/PostEditPage'

export interface CategoryEditPageProps extends PostEditPageProps {
	meta: any
}

export default function CategoryEditPage( props: CategoryEditPageProps ) {
	const meta = Object.assign( {}, props.meta )
	const image = meta.image ?? {
		url: null,
		id: null,
		title: null,
	}
	const media = Object.assign( [], props.meta?.media )
	const [ editData, setEditData ] = useState<any>( {
		image: image,
		media: media,
	} )

	function onEditDataChange( newData: any ) {
		setEditData( newData )
		props.onPostDataChange( newData )
	}

	function onTermDataChange( newData: any ) {
		let state = Object.assign( {}, editData )
		state = Object.assign( state, newData )
		onEditDataChange( state )
	}

	useEffect( () => {
		props.onPostDataChange( editData )
	}, [] )

	return (
		<TermEditPage
			onPostDataChange= { props.onPostDataChange }
			tca_enabled={ props.tca_enabled }
			tca_rules={ props.tca_rules }
		>
			<CategoryTermEditForm
				onChange={ onTermDataChange }
				editData={ editData }
			/>
		</TermEditPage>
	)
}
