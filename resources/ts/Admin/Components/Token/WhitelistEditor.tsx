import * as React from 'react';
import { Component } from 'react';

import { 
	Button,
	Flex,
	TextControl,
} from '@wordpress/components';

interface WhitelistEditorProps {
	items: any;
	onChange: any;
}

interface WhitelistEditorState {
	//
}

export default class WhitelistEditor extends Component<WhitelistEditorProps, WhitelistEditorState> {
	state: WhitelistEditorState = {
		//
	};
	constructor( props: WhitelistEditorProps ) {
		super( props );
		this.onAdd = this.onAdd.bind( this );
		this.onRemove = this.onRemove.bind( this );
		this.onAddressFieldChange = this.onAddressFieldChange.bind( this );
		this.onIndexFieldChange = this.onIndexFieldChange.bind( this );
	}
	
	onAdd() {
		const newState = Object.assign( [], this.props.items );
		newState.push( { key: '', value: '' } );
		this.props.onChange( newState );
	}
	
	onRemove( index: number ) {
		let newState = Object.assign( [], this.props.items );
		delete newState[ index ];
		this.removeEmpty( newState );
		this.props.onChange( newState );
	}
	
	onAddressFieldChange( key: any, value: any ) {
		const newState = Object.assign( [], this.props.items );
		newState[ key ].address = value;
		this.props.onChange( newState );
	}

	onIndexFieldChange( key: any, value: any ) {
		const newState = Object.assign( [], this.props.items );
		newState[ key ].index = value;
		this.props.onChange( newState );
	}

	removeEmpty( newState: any ) {
		newState = newState.filter( function ( item: any ) {
			return item != null;
		} );
	}

	render() {
		const listItems = this.props.items.map( ( item: any, i: number ) => {
			if ( !item ) { return }
			return (
				<Flex align="flex-end">
					<TextControl
						label="Contract Address"
						value={ item.address }
						onChange={ ( value: string ) => {
							this.onAddressFieldChange( i, value );
						} }
					/>
					<TextControl
						label="Token Index"
						value={ item.index }
						onChange={ ( value: string ) => {
							this.onIndexFieldChange( i, value );
						} }
					/>
					<Button
						isTertiary
						icon="no"
						onClick={ () => {
							this.onRemove( i );
						} }
					/>
				</Flex>
			);
		} );
		return ( 
			<Flex
				//@ts-ignore
				direction="column"
			>
				<label>
					<strong>Token Whitelist Editor</strong>
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
						onClick={ this.onAdd }
					>
						Add Item
					</Button>
				</div>
			</Flex>
		);
	}
}
