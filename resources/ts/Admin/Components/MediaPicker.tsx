import * as React from 'react'
import { MouseEvent } from 'react'
import { useInjection } from 'inversify-react'
import { TYPES } from '../../Types'

import { 
	Button,
	Flex,
} from '@wordpress/components'

interface MediaPickerProps {
	label?: string
	help?: string
	media: any
	onChange: any
}

declare const wp: any

export default function MediaPicker ( props: MediaPickerProps ) {
	const pluginUrl: string = useInjection( TYPES.Variables.pluginUrl )
	const placeholderUrl: string = `${pluginUrl}/resources/images/placeholder.png`
	function openMediaPicker() {
		let fileFrame = wp.media({
			title: 'Select media to upload',
			button: {
				text: 'Use this image',
			},
			multiple: false
		} )
		wp.media.frames.file_frame = fileFrame
		fileFrame.on( 'select', () => {
			let attachment = fileFrame.state().get( 'selection' ).first().toJSON()
			const state = {
				title: attachment.title,
				id: attachment.id,
				url: attachment.url,
				type: attachment.type,
			}
			props.onChange( state )
		} )
		fileFrame.open()
	}
	return (
		<div>
			{ props.media.id
			?	<Flex 
					align="center"
					justify="flex-start"
					gap={ 8 }
					style={ { cursor: 'pointer' } }
					onClick={ openMediaPicker }
				>
					<div style={ { position: 'relative', width: '100px', height: '100px', flexShrink: 0 } }>
						<Button
							isSmall
							isPrimary
							icon="no"
							style={ { position: 'absolute', top: 0, right: 0 } }
							onClick={ ( event: MouseEvent ) => {
								event.stopPropagation()
								props.onChange( {
									id: null,
									url: null,
									title: null,
								} )
							} }
						/>
						<img style={ { width: '100%', height: '100%', objectFit: 'cover' } } src={ props.media.type == 'image' ? props.media.url : placeholderUrl }/>
					</div>
					<span>{ props.media.title }</span>
				</Flex>
			:	<Button
					isSecondary
					onClick={ openMediaPicker }
				>
					Select File
				</Button>
			}
		</div>
	)
}
