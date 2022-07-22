import * as React from 'react'
import AssetField from './AssetField'
import AttributeRepeater from '../AttributeRepeater'
import MediaRepeater from '../MediaRepeater'

import { 
	Flex,
	SelectControl,
} from '@wordpress/components'

interface MetaEditFormProps {
	editData: any
	onChange: ( data: any ) => void
}

export default function MetaEditForm( props: MetaEditFormProps ) {
	function onAssetFieldChange( value: any ) {
		const state = Object.assign( {}, props.editData )
		state.asset = value
		props.onChange( state )
	}
	
	function onBlockchainFieldChange( value: any ) {
		const state = Object.assign( {}, props.editData )
		state.blockchain = value
		props.onChange( state )
	}

	function onProtocolFieldChange( value: any ) {
		const state = Object.assign( {}, props.editData )
		state.protocol = value
		props.onChange( state )
	}

	function onAttributesFieldChange( value: any ) {
		const state = Object.assign( {}, props.editData )
		state.attributes = value
		props.onChange( state )
	}

	function onMediaFieldChange( value: any ) {
		const state = Object.assign( {}, props.editData )
		state.media = value
		props.onChange( state )
	}

	function getProtocolOptions(): Array<any> {
		let options: any = []
		let blockchain = 'bitcoin'
		if ( props.editData?.blockchain && props.editData.blockchain != '' ) {
			blockchain = props.editData?.blockchain
		}
		switch( blockchain ) {
			case 'bitcoin':
				options = [
					{
						label: 'Counterparty',
						value: 'counterparty'
					}
				]
				break
			case 'ethereum':
				options = [
					{
						label: 'ERC20',
						value: 'erc20',
					},
					{
						label: 'ERC721',
						value: 'erc721',
					},
					{
						label: 'ERC1155',
						value: 'erc1155',
					},
				]
				break
		}
		return options
	}

	return (
		<form style={ { width: '100%', maxWidth: '500px' } }>
			<Flex
				//@ts-ignore
				direction="column"
			>
				<AssetField
					label="Asset"
					asset={ props.editData.asset }
					onChange={ onAssetFieldChange }
				/>
				<SelectControl
					label="Blockchain"
					value={ props.editData.blockchain }
					options={ [
						{ label: 'Bitcoin', value: 'bitcoin' },
						{ label: 'Ethereum', value: 'ethereum'  },
					] }
					onChange={ onBlockchainFieldChange }
				/>
				<SelectControl
					label="Protocol"
					value={ props.editData.protocol }
					options={ getProtocolOptions() }
					onChange={ onProtocolFieldChange }
				/>
				<AttributeRepeater
					label="Attribute Editor"
					help="Additional key-value attributes. They are displayed in the Details sections."
					attributes={ props.editData.attributes }
					onChange={ onAttributesFieldChange }
				/>
				<MediaRepeater
					label="Media Editor"
					help="Additional media, associated with the token."
					media={ props.editData.media }
					onChange={ onMediaFieldChange }
				/>
			</Flex>
		</form>
	)
}
