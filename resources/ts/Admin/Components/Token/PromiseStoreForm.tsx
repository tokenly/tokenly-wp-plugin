import * as React from 'react'
import UserSearchField from '../UserSearchField'
import AssetSearchField from '../AssetSearchField'
import SourceSelectField from '../Token/SourceSelectField'
import QuantityField from '../Token/QuantityField'
import SourceCollectionInterface from '../../../Interfaces/Collections/Token/SourceCollectionInterface'

import { 
	TextControl,
	TextareaControl,
	Flex,
	CheckboxControl,
} from '@wordpress/components'

interface PromiseStoreFormProps {
	loadingSources: boolean
	storeData: any
	sources: SourceCollectionInterface
	onChange: any
}

export default function PromiseStoreForm( props: PromiseStoreFormProps ) {
	function getBalance() {
		if ( !props.storeData?.sourceId ) {
			return []
		}
		const balance = props.sources.get( props.storeData?.sourceId )?.address?.balance
		return balance
	}

	function getCurrentAssetBalance() {
		if ( !props.storeData?.asset ) {
			return null
		}
		const asset = props.storeData.asset
		if ( asset == '' ) {
			return null
		}
		let balance = props.sources.get( props.storeData?.sourceId )?.address?.balance
		if ( !balance ) {
			return null
		}
		balance = Object.values( balance )
		balance = balance.filter( ( balance: any ) => {
			let assetName = balance.asset.address
			if ( balance.asset.index ) {
				assetName = `${assetName}:${balance.asset.index}`
			}
			return assetName === props.storeData?.asset
		} )
		if ( balance.length == 0 ) {
			return null
		}
		return balance[0]
	}

	function getMaxCount() {
		const balance = getCurrentAssetBalance()
		if ( !balance ) {
			return 0
		}
		const quantity = parseFloat( balance.quantity.value )
		return quantity
	}

	function isAssetValid() {
		const balance = getCurrentAssetBalance()
		if ( balance || props.storeData?.pseudo == true ) {
			return true
		}
		return false
	}

	function getAssetName( asset: any ) {
		let assetName = asset.address
		if ( asset.index ) {
			assetName = `${assetName}:${asset.index}`
		}
		return assetName
	}

	function onDestinationFieldChange( value: any ) {
		const state = Object.assign( {}, props.storeData )
		state.destination = value
		props.onChange( state )
	}

	function onSourceFieldChange( value: any ) {
		const state = Object.assign( {}, props.storeData )
		state.source_id = value
		props.onChange( state )
	}

	function onPseudoFieldChange( value: any ) {
		const state = Object.assign( {}, props.storeData )
		state.pseudo = value
		state.asset = null
		state.quantity = 0
		props.onChange( state )
	}

	function onAssetFieldChange( value: any ) {
		const state = Object.assign( {}, props.storeData )
		state.asset = value
		props.onChange( state )
	}

	function onQuantityFieldChange( value: any ) {
		const state = Object.assign( {}, props.storeData )
		state.quantity = value
		props.onChange( state )
	}

	function onRefFieldChange( value: any ) {
		const state = Object.assign( {}, props.storeData )
		state.ref = value
		props.onChange( state )
	}

	function onNoteFieldChange( value: any ) {
		const state = Object.assign( {}, props.storeData )
		state.note = value
		props.onChange( state )
	}

	return (
		<div style={ { width: '100%' } }>
			{ props.storeData
		?	<Flex
				//@ts-ignore
				direction="column"
				style={ { maxWidth: '320px' } }
			>
				<SourceSelectField
					label="Source *"
					onChange={ onSourceFieldChange }
					source={ props.storeData?.sourceId }
					sources={ props.sources }
					loading={ props.loadingSources }
					inputProps={ {
						required: true,
					} }
				/>
				<div>
					<label>
						<div>Destination *</div>
						<div style={ { opacity: 0.8 } }>WordPress username. The user who will receive the asset.</div>
						<UserSearchField
							user={ props.storeData.destination }
							onChange={ onDestinationFieldChange }
							inputProps={ {
								required: true,
							} }
						/>
					</label>
				</div>
				<div>
					<CheckboxControl
						label="Pseudo Promise *"
						checked={ props.storeData.pseudo }
						onChange={ onPseudoFieldChange }
					/>
				</div>
				<div>
					<label>
						<div>Asset *</div>
						<div style={ { opacity: 0.8 } }>
							<div>Name of the asset that will be promised.</div>
							<div>Note: Only the whitelisted assets are searchable.</div>
						</div>
						<AssetSearchField
							assets={ getBalance() }
							disabled={ !props.storeData.source_id }
							asset={ props.storeData?.asset }
							onChange={ onAssetFieldChange }
							inputProps={ {
								required: true,
							} }
						/>
					</label>
				</div>
				<Flex
					//@ts-ignore
					direction="column"
				>
					<QuantityField
						quantity={ props.storeData?.quantity }
						onChange={ onQuantityFieldChange }
						inputProps={ {
							required: true,
						} }
					/>
					<TextControl
						label="Reference"
						help="Extra reference data."
						value={ props.storeData?.ref }
						onChange={ onRefFieldChange }
					/>
					<TextareaControl
						label="Note"
						help="Note to display to user."
						value={ props.storeData?.note }
						onChange={ onNoteFieldChange }
					/>
				</Flex>
			</Flex>
		: 	<div style={ { opacity: 0.8 } }>No sources registered.</div>
		}
		</div>
	)
}
