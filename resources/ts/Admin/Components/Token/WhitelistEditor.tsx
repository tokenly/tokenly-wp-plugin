import * as React from 'react';

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
		newState.push( { key: '', value: '' } );
		props.onChange( newState );
	}
	
	function onRemove( index: number ) {
		let newState = Object.assign( [], props.items );
		delete newState[ index ];
		removeEmpty( newState );
		props.onChange( newState );
	}
	
	function onAddressFieldChange( key: any, value: any ) {
		const newState = Object.assign( [], props.items );
		newState[ key ].address = value;
		props.onChange( newState );
	}

	function onIndexFieldChange( key: any, value: any ) {
		const newState = Object.assign( [], props.items );
		newState[ key ].index = value;
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
			<Flex align="flex-end">
				<Flex>
					<TextControl
						label="Contract Address"
						value={ item.address }
						onChange={ ( value: string ) => {
							onAddressFieldChange( i, value );
						} }
					/>
					<TextControl
						label="Token Index"
						value={ item.index }
						onChange={ ( value: string ) => {
							onIndexFieldChange( i, value );
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
				>{ listItems }</Flex>
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
