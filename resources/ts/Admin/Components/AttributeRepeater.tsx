import * as React from 'react';
import { Component } from 'react';
import { Attribute } from '../../Interfaces';

import { 
	Button,
	Flex,
	TextControl,
} from '@wordpress/components';

interface AttributeRepeaterProps {
	label?: string;
	help?: string;
	attributes: Array<Attribute>;
	onChange: any;
}

interface AttributeRepeaterState {
	//
}

export default class AttributeRepeater extends Component<AttributeRepeaterProps, AttributeRepeaterState> {
	state: AttributeRepeaterState = {
		//
	};
	constructor( props: AttributeRepeaterProps ) {
		super( props );
		this.onAdd = this.onAdd.bind( this );
		this.onRemove = this.onRemove.bind( this );
		this.onKeyFieldChange = this.onKeyFieldChange.bind( this );
		this.onValueFieldChange = this.onValueFieldChange.bind( this );
	}
	
	onAdd() {
		const newState = Object.assign( [], this.props.attributes );
		newState.push( { key: '', value: '' } );
		this.props.onChange( newState );
	}
	
	onRemove( index: number ) {
		let newState = Object.assign( [], this.props.attributes );
		delete newState[ index ];
		this.removeEmpty( newState );
		this.props.onChange( newState );
	}
	
	onKeyFieldChange( key: any, value: any ) {
		const newState = Object.assign( [], this.props.attributes );
		newState[ key ].key = value;
		this.props.onChange( newState );
	}

	onValueFieldChange( key: any, value: any ) {
		const newState = Object.assign( [], this.props.attributes );
		newState[ key ].value = value;
		this.props.onChange( newState );
	}

	removeEmpty( newState: any ) {
		newState = newState.filter( function ( attribute: any ) {
			return attribute != null;
		} );
	}

	render() {
		const listItems = this.props.attributes.map( ( attribute: Attribute, i: number ) => {
			if ( !attribute ) { return }
			return (
				<Flex justify="flex-start" style={ { alignItems: 'flex-end', margin: '8px 0' } }>
					<TextControl
						label="Key"
						value={ attribute.key }
						onChange={ ( value: string ) => {
							this.onKeyFieldChange( i, value );
						} }
					/>
					<TextControl
						label="Value"
						value={ attribute.value }
						onChange={ ( value: string ) => {
							this.onValueFieldChange( i, value );
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
			<div style={ { display: 'inline-block' } }>
				<label>{ this.props.label }
					<div style={ { opacity: 0.8 } }>{ this.props.help }</div>
					<ul>{ listItems }</ul>
				</label>
				<Button
					isSecondary
					isLarge
					onClick={ this.onAdd }
				>
					Add attribute
				</Button>
			</div>
		);
	}
}
