import * as React from 'react'
import FormTable from '../FormTable'
import TcaSettings from '../../../Models/Settings/TcaSettings'
import TcaSettingsInterface
	from '../../../Interfaces/Models/Settings/TcaSettingsInterface'

import { 
	Flex,
	CheckboxControl,
	ToggleControl,
} from '@wordpress/components'

interface TcaSettingsFormProps {
	settings: TcaSettingsInterface
	data: {
		post_types: {
			[index: string]: string;
		}
		taxonomies: {
			[index: string]: string;
		}
	}
	onChange: ( data: any ) => void
}

export default function TcaSettingsForm( props: TcaSettingsFormProps ) {
	function onChange( newSettings: any ) {
		props.onChange( newSettings )
	}

	function isPostTypeChecked( key: string ) {
		let checked = false
		if ( props.settings?.postTypes && props.settings?.postTypes[ key ] ) {
			checked = props.settings.postTypes[ key ]
		}
		return checked
	}

	function isTaxonomyChecked( key: string ) {
		let checked = false
		if ( props.settings?.taxonomies && props.settings?.taxonomies[ key ] ) {
			checked = props.settings.taxonomies[ key ]
		}
		return checked
	}

	function onFilterMenuItemsFieldChange( value: any ) {
		const settings = Object.assign( new TcaSettings(), props.settings )
		settings.filterMenuItems = value
		onChange( settings )
	}
 
	function onFilterPostResultsFieldChange( value: any ) {
		const settings = Object.assign( new TcaSettings(), props.settings )
		settings.filterPostResults = value
		onChange( settings )
	}

	function onPostTypeCheck( key: string, value: boolean ) {
		const settings = Object.assign( new TcaSettings(), props.settings )
		settings.postTypes[ key ] = value
		onChange( settings )
	}

	function onTaxonomyCheck( key: string, value: boolean ) {
		const settings = Object.assign( new TcaSettings(), props.settings )
		settings.taxonomies[ key ] = value
		onChange( settings )
	}

	const postTypes: any = []
	if ( props.data.post_types ) {
		Object.keys( props.data.post_types ).map( ( key: string, index: number ) => {
			const label = props.data.post_types[ key ]
			const item = (
				<CheckboxControl
					label={ label }
					checked={ isPostTypeChecked( key ) }
					onChange={ ( value: boolean ) => {
						onPostTypeCheck( key, value )
					} }
				/>
			)
			postTypes.push( item )
		} )
	}
	const taxonomies: any = []
	if ( props.data.taxonomies ) {
		Object.keys( props.data.taxonomies ).map( ( key: string, index: number ) => {
			const label = props.data.taxonomies[ key ]
			const item = (
				<CheckboxControl
					label={ label }
					checked={ isTaxonomyChecked( key ) }
					onChange={ ( value: boolean ) => {
						onTaxonomyCheck( key, value )
					} }
				/>
			)
			taxonomies.push( item )
		})
	}
	return (
		<div>
			<div>
				<legend style={ { marginBottom: '8px' } }>
					<b>Filtering Options</b>
					<div>Filtering the content can slow down page loading speed. <br />
						The following options allow fine-grained control over what gets filtered.</div>
				</legend>
			</div>
			<FormTable
				rows={
					[
						{
							label: 'Menu Items',
							component:
								<ToggleControl
									label="Filter Menu Items"
									help="Filters the menus made via Customizer. Note that the custom / external links will not be tested."
									checked={ props.settings.filterMenuItems }
									onChange={ onFilterMenuItemsFieldChange }
								/>
						},
						{
							label: 'Post Results',
							component:
								<ToggleControl
									label="Filter Post Results"
									help="Filters the post listings which are not controlable by the menu editor, like recent post list."
									checked={ props.settings.filterPostResults }
									onChange={ onFilterPostResultsFieldChange }
								/>
						},
					]
				}
			/>
			<hr />
			<FormTable
				rows={
					[
						{
							label: 'Post Types',
							component:
								<div>
									<div>The selected post types will be able to use the TCA functions. <br/> The rule editor will be available at the post editing screen.</div>
									<Flex
										//@ts-ignore
										direction="column"
										style={ { flex: '1', maxWidth: '468px', marginTop: '12px' } }
									>
										{ postTypes.length > 0 ? postTypes : <div style={ { opacity: 0.6 } }>No post types found</div>}
									</Flex>
								</div>
						},
						{
							label: 'Taxonomies',
							component:
								<div>
									<div>The selected taxonomies will be able to use the TCA functions. <br/> The rule editor will be available at the taxonomy term editing screen.</div>
									<Flex
										//@ts-ignore
										direction="column"
										style={ { flex: '1', maxWidth: '468px', marginTop: '12px' } }
									>
										{ taxonomies.length > 0 ? taxonomies : <div style={ { opacity: 0.6 } }>No taxonomies found</div>}
									</Flex>
								</div>
						},
					]
				}
			/>
		</div>
	)
}
 

