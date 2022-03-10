import * as React from 'react';
import eventBus from "../../../../EventBus";

import {
	Button,
	Flex,
	SelectControl,
	TextControl,
} from '@wordpress/components';

interface TcaRuleEditorProps {
	editData?: any;
	onChange: any;
}

export default function TcaRuleEditor( props: TcaRuleEditorProps ) {
	function onAdd() {
		const newRules = Object.assign( [], props.editData.tcaRules );
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
		let newRules = Object.assign( [], props.editData.tcaRules );
		delete newRules[ index ];
		newRules = removeEmpty( newRules );
		props.onChange( newRules );
	}
	
	function onAssetFieldChange( key: any, value: any ) {
		const newRules = Object.assign( [], props.editData.tcaRules );
		newRules[ key ].asset = value;
		props.onChange( newRules );
	}

	function onLogicFieldChange( key: any, value: any ) {
		const newRules = Object.assign( [], props.editData.tcaRules );
		newRules[ key ].op = value;
		props.onChange( newRules );
	}

	function onQuantityFieldChange( key: any, value: any ) {
		const newRules = Object.assign( [], props.editData.tcaRules );
		newRules[ key ].quantity = value;
		props.onChange( newRules );
	}

	function onGroupingFieldChange( key: any, value: any ) {
		const newRules = Object.assign( [], props.editData.tcaRules );
		newRules[ key ].stackOp = value;
		props.onChange( newRules );
	}

	let rules = props.editData.tcaRules ?? [];
	if ( typeof rules === 'object' ) {
		rules = Object.values( rules );
	}
	const listItems = rules.map( ( rule: any, i: number ) => {
		return (
			<Flex justify="flex-start" align="center">
				<TextControl
					style={ { maxWidth: '170px' } }
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
					style={ { maxWidth: '75px' } }
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
						style={ { width: '64px' } }
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
		<fieldset style={ { border: '1px solid #dcdcde', padding: '12px' } }>
		<legend>Rule Editor</legend>
		<div style={ { opacity: 0.8, marginBottom: '12px' } }>The token inventory of the visitor will be checked against these rules. If not passed - access to the content will be prevented.</div>
				{ ( listItems.filter( Boolean ).length > 0 )
					?	<ul>{ listItems }</ul>
					:	<div style={ { opacity: 0.5, margin: '8px 0' } }>There are no rules.</div>
				}
				<Button
					isSecondary
					isLarge
					onClick={ onAdd }
				>
					Add Rule
				</Button>
		</fieldset>
	);
}
