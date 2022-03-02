import * as React from 'react';
import { Fragment } from 'react';
import AssetField from './AssetField';

import { 
	Button,
	Flex,
	TextControl,
} from '@wordpress/components';

interface WhitelistEditorProps {
	items: any;
	onChange: any;
}

export default function WhitelistEditor( props: WhitelistEditorProps ) {
	function onAdd() {
		const newState = Object.assign( [], props.items );
		newState.push( { asset: {
			index: '',
			address: '',
		} } );
		props.onChange( newState );
	}
	
	function onRemove( index: number ) {
		let newState = Object.assign( [], props.items );
		delete newState[ index ];
		removeEmpty( newState );
		props.onChange( newState );
	}
	
	function onAssetFieldChange( key: any, value: any ) {
		const newState = Object.assign( [], props.items );
		newState[ key ].asset = value;
		props.onChange( newState );
	}

	function removeEmpty( newState: any ) {
		newState = newState.filter( function ( item: any ) {
			return item != null;
		} );
	}

	const listItems = props.items.map( ( item: any, i: number ) => {
		if ( !item ) { return }
		return (
			<Flex align="center">
				<Flex>
					<AssetField
						asset={ item.asset }
						onChange={ ( value: any ) => {
							onAssetFieldChange( i, value );	
						} }
					/>
				</Flex>
				<Button
					isTertiary
					icon="no"
					onClick={ () => {
						onRemove( i );
					} }
				/>
			</Flex>
		);
	} );
	return ( 
		<Flex
			//@ts-ignore
			direction="column"
			style={ { width: '100%', maxWidth: '768px' } }
		>
			<label>
				<b>Token Whitelist Editor</b>
				<Flex
					//@ts-ignore
					direction="column"
					style={ { marginTop: '8px' } }
				>
					{ listItems.length > 0
						? <Fragment>{ listItems }</Fragment>
						: <div style={ { opacity: 0.5 } }>There are not whitelisted tokens.</div>
					}
				</Flex>
			</label>
			<div>
				<Button
					isSecondary
					isLarge
					onClick={ onAdd }
					style={ { marginTop: '12px' } }
				>
					Add Item
				</Button>
			</div>
		</Flex>
	);
}
