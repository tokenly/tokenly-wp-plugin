import * as React from 'react';
import { Component } from 'react';
import { Attribute } from '../../Interfaces';

import { 
	Button,
	Flex,
	TextControl,
	Dashicon,
} from '@wordpress/components';

interface AttributeRepeaterProps {
	label?: string;
	help?: string;
	attributes: Array<Attribute>;
	onUpdate: any;
}

interface AttributeRepeaterState {
	attributes: Array<Attribute>;
}

export class AttributeRepeater extends Component<AttributeRepeaterProps, AttributeRepeaterState> {
	state: AttributeRepeaterState = {
		attributes: [],
	};
	constructor( props: AttributeRepeaterProps ) {
		super( props );
		this.onUpdate = props.onUpdate;
		this.state.attributes = Object.assign( [], props.attributes );
	}
	
	onUpdate( attributes: Array<Attribute> ) {
		//
	}
	
	onAdd() {
		let newState = Object.assign( {}, this.state );
		newState.attributes[newState.attributes.length] = { key: '', value: '' };
		this.setState( newState );
		this.dispatchUpdate();
	}
	
	onRemove( index: number ) {
		let newState = Object.assign( {}, this.state );
		delete newState.attributes[index];
		this.setState( newState );
		this.dispatchUpdate();
	}
	
	dispatchUpdate() {
		this.onUpdate( this.state.attributes );
	}

	render() {
		const listItems = this.state.attributes.map( ( attribute: Attribute, i: number ) => {
			return (
				<Flex justify="flex-start" style={ { alignItems: 'flex-end', margin: '8px 0' } }>
					<TextControl
						label="Key"
						value={ attribute.key }
						onChange={ ( value: string ) => {
								let newState = Object.assign( {}, this.state );
								newState.attributes[i].key = value;
								this.setState( { ...newState } );
								this.dispatchUpdate();
							}
						}
					/>
					<TextControl
						label="Value"
						value={ attribute.value }
						onChange={ ( value: string ) => {
								let newState = Object.assign( {}, this.state );
								newState.attributes[ i ].value = value;
								this.setState( { ...newState } );
								this.dispatchUpdate();
							}
						}
					/>
					<Button
						isTertiary
						onClick={ () => {
							this.onRemove( i );
						}}
					>
						<Dashicon icon="no" />
					</Button>
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
					onClick={ () => {
						this.onAdd();
					}}
				>
					Add attribute
				</Button>
			</div>
		);
	}
}
