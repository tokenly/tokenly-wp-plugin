import * as React from 'react';
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

export default function AttributeRepeater ( props: AttributeRepeaterProps ) {
	function onAdd() {
		const newState = Object.assign( [], props.attributes );
		newState.push( { key: '', value: '' } );
		props.onChange( newState );
	}
	
	function onRemove( index: number ) {
		let newState = Object.assign( [], props.attributes );
		delete newState[ index ];
		removeEmpty( newState );
		props.onChange( newState );
	}
	
	function onKeyFieldChange( key: any, value: any ) {
		const newState = Object.assign( [], props.attributes );
		newState[ key ].key = value;
		props.onChange( newState );
	}

	function onValueFieldChange( key: any, value: any ) {
		const newState = Object.assign( [], props.attributes );
		newState[ key ].value = value;
		props.onChange( newState );
	}

	function removeEmpty( newState: any ) {
		newState = newState.filter( function ( attribute: any ) {
			return attribute != null;
		} );
	}

	const listItems = props.attributes.map( ( attribute: Attribute, i: number ) => {
		if ( !attribute ) { return }
		return (
			<Flex justify="flex-start" align="flex-end">
				<TextControl
					label="Key"
					value={ attribute.key }
					onChange={ ( value: string ) => {
						onKeyFieldChange( i, value );
					} }
				/>
				<TextControl
					label="Value"
					value={ attribute.value }
					onChange={ ( value: string ) => {
						onValueFieldChange( i, value );
					} }
				/>
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
			style={ { display: 'inline-block' } }
		>
			<label>{ props.label }
				<Flex
					//@ts-ignore
					direction="column"
				>
					<div style={ { opacity: 0.8 } }>{ props.help }</div>
					<Flex
						//@ts-ignore
						direction="column"
					>
						{ listItems }
					</Flex>
				</Flex>
			</label>
			<Button
				isSecondary
				isLarge
				onClick={ onAdd }
				style={ { marginTop: '18px' } }
			>
				Add Attribute
			</Button>
		</Flex>
	);
}
