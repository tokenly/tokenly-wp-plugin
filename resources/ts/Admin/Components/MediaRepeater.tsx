import * as React from 'react'
import MediaPicker from '../Components/MediaPicker'
import Fieldset from '../Components/Fieldset'

import { 
	Button,
	Card,
	CardBody,
	Flex,
} from '@wordpress/components'

interface MediaRepeaterProps {
	label?: string
	help?: string
	media: Array<any>
	onChange: any
}

export default function MediaRepeater ( props: MediaRepeaterProps ) {
	function onAdd() {
		const newState = Object.assign( [], props.media )
		newState.push( { id: null, url: null } )
		props.onChange( newState )
	}
	
	function onRemove( index: number ) {
		let newState = Object.assign( [], props.media )
		delete newState[ index ]
		removeEmpty( newState )
		props.onChange( newState )
	}

	function removeEmpty( newState: any ) {
		newState = newState.filter( function ( attribute: any ) {
			return attribute != null
		} )
	}

	function onMediaChange( value: any, i: number ): void {
		const state = Object.assign( [], media )
		state[i] = value
		props.onChange( state )
	}

	const media: Array<any> = Object.assign( [], props.media )
	const listItems: Array<JSX.Element> = media.map( ( media: any, i: number ) => {
		if ( !media ) { return }
		return (
			<Card>
				<CardBody>
					<Flex
						align="center"
					>
						<MediaPicker
								media={ media }
								onChange={ ( value: any ) => {
									onMediaChange( value, i )
								} }
						/>
						<Button
							isTertiary
							icon="no"
							onClick={ () => {
								onRemove( i )
							} }
						/>
					</Flex>
				</CardBody>
			</Card>
		)
	} ) ?? []
	return ( 
		<Fieldset label={ props.label } help={ props.help }>
			{ ( listItems.filter( Boolean ).length > 0 )
				?	<Flex
						//@ts-ignore
						direction="column"
						style={ { margin: '12px 0' } }
					>
						{ listItems }
					</Flex>
				:	<div style={ { opacity: 0.5, margin: '8px 0' } }>There is no additional media.</div>
			}
			<Button
				isSecondary
				isLarge
				onClick={ onAdd }
			>
				Add Media
			</Button>
		</Fieldset>
	)
}
