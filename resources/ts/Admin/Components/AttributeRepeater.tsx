import * as React from 'react';
import { Attribute } from '../../Interfaces';
import Fieldset from '../Components/Fieldset';

import { 
	Button,
	Card,
	CardHeader,
	CardBody,
	CardFooter,
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
			<Flex justify="flex-start" align="center">
				<TextControl
					placeholder="Key"
					value={ attribute.key }
					onChange={ ( value: string ) => {
						onKeyFieldChange( i, value );
					} }
				/>
				<TextControl
					placeholder="Value"
					value={ attribute.value }
					onChange={ ( value: string ) => {
						onValueFieldChange( i, value );
					} }
				/>
				<Button
					isSmall
					isTertiary
					icon="no"
					style={ { marginBottom: '8px' } }
					onClick={ () => {
						onRemove( i );
					} }
				/>
			</Flex>
		);
	} );
	return ( 
		<Fieldset label={ props.label } help={ props.help }>
			<Flex
				//@ts-ignore
				direction="column"
				style={ { display: 'inline-block' } }
			>
				<Flex
					//@ts-ignore
					direction="column"
				>
					<Flex
						//@ts-ignore
						direction="column"
					>
						{ ( listItems.filter( Boolean ).length > 0 )
							?	<ul>{ listItems }</ul>
							:	<div style={ { opacity: 0.5 } }>There are no attributes.</div>
						}
					</Flex>
				</Flex>
				<Button
					isSecondary
					isLarge
					onClick={ onAdd }
				>
					Add Attribute
				</Button>
			</Flex>
		</Fieldset>
	);
}
