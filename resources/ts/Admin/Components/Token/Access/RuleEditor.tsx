import * as React from 'react';

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

import Rule from '../../../../Models/Token/Rule'

export default function TcaRuleEditor( props: TcaRuleEditorProps ) {
	function onAdd() {
		const newRules = props.editData.tcaRules.clone();
		newRules.set( newRules.size, ( new Rule() ).fromJson( {
			asset: null,
			quantity: 0,
			op: '=',
			stackOp: 'AND',
		} ) )
		props.onChange( newRules )
	}

	function removeEmpty( newRules: any ) {
		return newRules.filter( function ( rule: any ) {
			return rule != null;
		} );
	}
	
	function onRemove( index: number ) {
		const newRules = props.editData.tcaRules.clone();
		newRules.delete(index);
		props.onChange( newRules );
	}
	
	function onAssetFieldChange( key: any, value: any ) {
		const newRules = props.editData.tcaRules.clone()
		newRules.get(key).asset = value;
		props.onChange( newRules );
	}

	function onLogicFieldChange( key: any, value: any ) {
		const newRules = props.editData.tcaRules.clone()
		newRules.get(key).op = value;
		props.onChange( newRules );
	}

	function onQuantityFieldChange( key: any, value: any ) {
		const newRules = props.editData.tcaRules.clone()
		newRules.get(key).quantity = value;
		props.onChange( newRules );
	}

	function onGroupingFieldChange( key: any, value: any ) {
		const newRules = props.editData.tcaRules.clone()
		newRules.get(key).stackOp = value;
		props.onChange( newRules );
	}

	const listItems = Array.from(
		props.editData.tcaRules.values()
	).map( ( rule: any, i: number ) => {
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
