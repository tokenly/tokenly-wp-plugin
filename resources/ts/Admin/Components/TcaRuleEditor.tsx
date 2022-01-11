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
	onUpdate: any;
}

interface TcaRuleEditorState {
	rules: Array<any>;
}

export default class TcaRuleEditor extends Component<TcaRuleEditorProps, TcaRuleEditorState> {
	state: TcaRuleEditorState = {
		rules: [],
	};
	constructor( props: TcaRuleEditorProps ) {
		super( props );
		this.onUpdate = props.onUpdate;
		this.state.rules = Object.assign( [], props.rules );
	}
	
	onUpdate( rules: Array<Attribute> ) {
		//
	}
	
	onAdd() {
		let newState = Object.assign( {}, this.state );
		newState.rules[newState.rules.length] = { asset: null, quantity: 0, op: '=', stackOp: 'AND' };
		this.setState( newState );
		this.dispatchUpdate();
	}
	
	onRemove( rule: any ) {
		let newState = Object.assign( {}, this.state );
		let index = this.state.rules.indexOf(rule)
		if ( index !== -1 ) {
			newState.rules.splice( index, 1 );
		}
		this.setState( newState );
		this.dispatchUpdate();
	}
	
	dispatchUpdate() {
		this.onUpdate( this.state.rules );
	}

	render() {
		const listItems = this.state.rules.map( ( rule: any, i: number ) => {
			return (
				<Flex justify="flex-start" align="center">
					<TextControl
						value={ rule.asset }
						placeholder="Asset"
						onChange={ ( value: string ) => {
								let newState = Object.assign( {}, this.state );
								newState.rules[ i ].asset = value;
								this.setState( { ...newState } );
								this.dispatchUpdate();
							}
						}
					/>
					<SelectControl
						placeholder="Logic"
						value={ rule.op }
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
						onChange={ ( value: string ) => {
							let newState = Object.assign( {}, this.state );
							newState.rules[ i ].op = value;
							this.setState( { ...newState } );
							this.dispatchUpdate();
						} }
					/>
					<TextControl
						value={ rule.quantity }
						placeholder="Quantity"
						style={ { maxWidth: '100px' } }
						type="number"
						min={ 0 }
						onChange={ ( value: string ) => {
								let newState = Object.assign( {}, this.state );
								newState.rules[ i ].quantity = value;
								this.setState( { ...newState } );
								this.dispatchUpdate();
							}
						}
					/>
					{ i > 0 &&
						<SelectControl
							placeholder="Grouping"
							value={ rule.stackOp }
							options={ [
								{ label: 'AND' , value: 'AND' },
								{ label: 'OR'  , value: 'OR'  },
							] }
							onChange={ ( value: string ) => {
								let newState = Object.assign( {}, this.state );
								newState.rules[ i ].stackOp = value;
								this.setState( { ...newState } );
								this.dispatchUpdate();
							} }
						/>
					}
					<Button
						isTertiary
						isSmall
						style={{marginBottom: '8px'}}
						onClick={ () => {
							this.onRemove( rule );
						}}
					>
						<Dashicon icon="no" />
					</Button>
				</Flex>
			);
		} );
		return ( 
			<div style={ { display: 'inline-block', marginTop: '12px' } }>
				<label>
					<strong>TCA Rule Editor</strong>
					<div style={ { opacity: 0.8 } }>The visitor's token inventory will be checked against these rules. If not passed - access to the content will be prevented.</div>
					<ul>{ listItems }</ul>
				</label>
				<Button
					isSecondary
					isLarge
					onClick={ () => {
						this.onAdd();
					}}
				>
					Add Rule
				</Button>
			</div>
		);
	}
}
