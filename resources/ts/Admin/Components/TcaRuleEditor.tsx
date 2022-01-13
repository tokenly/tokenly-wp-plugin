import * as React from 'react';
import { Component } from 'react';
import { Attribute } from '../../Interfaces';

import { 
	Button,
	Flex,
	SelectControl,
	TextControl,
	Dashicon,
	// @ts-ignore
	__experimentalNumberControl as NumberControl
} from '@wordpress/components';

interface TcaRuleEditorProps {
	rules?: Array<any>;
	onChange: any;
}

export default function TcaRuleEditor( props: TcaRuleEditorProps ) {
	function onAdd() {
		const newRules = Object.assign( [], props.rules );
		newRules.push( {
			asset: null,
			quantity: 0,
			op: '=',
			stackOp: 'AND',
		} );
		props.onChange( newRules );
	}

	function removeEmpty( newRules: any ) {
		return newRules.filter( function ( rule: any ) {
			return rule != null;
		} );
	}
	
	function onRemove( index: number ) {
		let newRules = Object.assign( [], props.rules );
		delete newRules[ index ];
		newRules = removeEmpty( newRules );
		props.onChange( newRules );
	}
	
	function onAssetFieldChange( key: any, value: any ) {
		const newRules = Object.assign( [], props.rules );
		newRules[ key ].asset = value;
		props.onChange( newRules );
	}

	function onLogicFieldChange( key: any, value: any ) {
		const newRules = Object.assign( [], props.rules );
		newRules[ key ].op = value;
		props.onChange( newRules );
	}

	function onQuantityFieldChange( key: any, value: any ) {
		const newRules = Object.assign( [], props.rules );
		newRules[ key ].quantity = value;
		props.onChange( newRules );
	}

	function onGroupingFieldChange( key: any, value: any ) {
		const newRules = Object.assign( [], props.rules );
		newRules[ key ].stackOp = value;
		props.onChange( newRules );
	}

	let rules = props.rules;
	if ( typeof rules === 'object' ) {
		rules = Object.values( rules );
	}
	const listItems = rules.map( ( rule: any, i: number ) => {
		return (
			<Flex justify="flex-start" align="center">
				<TextControl
					value={ rule?.asset ?? '' }
					placeholder="Asset"
					onChange={ ( value: any ) => {
						onAssetFieldChange( i, value )
					} }
				/>
				<SelectControl
					placeholder="Logic"
					value={ rule?.op }
					options={ [
						{ label: '>=' , value: '>=' },
						{ label: '>'  , value: '>'  },
						{ label: '='  , value: '='  },
						{ label: '==' , value: '==' },
						{ label: '!=' , value: '!=' },
						{ label: '!'  , value: '!'  },
						{ label: '<'  , value: '<'  },
						{ label: '<=' , value: '<=' },
					] }
					onChange={ ( value: any ) => {
						onLogicFieldChange( i, value );
					} }
				/>
				<TextControl
					value={ rule?.quantity }
					placeholder="Quantity"
					style={ { maxWidth: '100px' } }
					type="number"
					min={ 0 }
					onChange={ ( value: any ) => {
						onQuantityFieldChange( i, value );
					} }
				/>
				{ i > 0 &&
					<SelectControl
						placeholder="Grouping"
						value={ rule?.stackOp }
						options={ [
							{ label: 'AND' , value: 'AND' },
							{ label: 'OR'  , value: 'OR'  },
						] }
						onChange={ ( value: any ) => {
							onGroupingFieldChange( i, value );
						} }
					/>
				}
				<Button
					isTertiary
					isSmall
					style={ { marginBottom: '8px' } }
					onClick={ () => {
						onRemove( i );
					} }
					icon="no"
				/>
			</Flex>
		);
	} );
	return ( 
		<div style={ { display: 'inline-block', marginTop: '12px' } }>
			<label>
				<b>TCA Rule Editor</b>
				<div style={ { opacity: 0.8 } }>The visitor's token inventory will be checked against these rules. If not passed - access to the content will be prevented.</div>
				<ul>{ listItems }</ul>
			</label>
			<Button
				isSecondary
				isLarge
				onClick={ onAdd }
			>
				Add Rule
			</Button>
		</div>
	);
}
