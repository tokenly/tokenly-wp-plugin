// import * as React from 'react';
// import { Component } from 'react';
// import { Attribute } from '../../Interfaces';

// import { 
// 	Button,
// 	Flex,
// 	TextControl,
// 	Dashicon,
// } from '@wordpress/components';

// interface AttributeRepeaterProps {
// 	attributes: Array<Attribute>;
// 	onUpdate: any;
// }

// interface AttributeRepeaterState {
// 	whitelist: Array<WhitelistItem>;
// }

// export class AttributeRepeater extends Component<AttributeRepeaterProps, AttributeRepeaterState> {
// 	state: AttributeRepeaterState = {
// 		whitelist: [],
// 	};
// 	constructor( props: AttributeRepeaterProps ) {
// 		super( props );
// 		this.onUpdate = props.onUpdate;
// 		this.state.attributes = Object.assign( [], props.attributes );
// 	}
	
// 	onUpdate( whitelist: Array<WhitelistItem> ) {
// 		//
// 	}
	
// 	onAdd() {
// 		let newState = Object.assign( {}, this.state );
// 		newState.whitelist[newState.whitelist.length] = { address: '', index: '' };
// 		this.setState( newState );
// 		this.dispatchUpdate();
// 	}
	
// 	onRemove( index: number ) {
// 		let newState = Object.assign( {}, this.state );
// 		delete newState.whitelist[index];
// 		this.setState( newState );
// 		this.dispatchUpdate();
// 	}
	
// 	dispatchUpdate() {
// 		this.onUpdate( this.state.attributes );
// 	}

// 	render() {
// 		const listItems = this.state.attributes.map( ( listItem: WhitelistItem, i: number ) =>
// 			<div>
// 				<Flex style={ { alignItems: 'flex-end', margin: '8px 0' } }>
// 					<TextControl
// 						label="Key"
// 						value={ listItem.address }
// 						onChange={ ( value: string ) => {
// 								let newState = Object.assign( {}, this.state );
// 								newState.whitelist[i].address = value;
// 								this.setState( { ...newState } );
// 								this.dispatchUpdate();
// 							}
// 						}
// 					/>
// 					<TextControl
// 						label="Value"
// 						value={ listItem.index }
// 						onChange={ ( value: string ) => {
// 								let newState = Object.assign( {}, this.state );
// 								newState.whitelist[ i ].index = value;
// 								this.setState( { ...newState } );
// 								this.dispatchUpdate();
// 							}
// 						}
// 					/>
// 					<Button
// 						isTertiary
// 						onClick={ () => {
// 							this.onRemove( i );
// 						}}
// 					>
// 						<Dashicon icon="no" />
// 					</Button>
// 				</Flex>
// 			</div>
// 		);
// 		return <div>
// 				<ul>{listItems}</ul>
// 				<Button
// 					isSecondary
// 					isLarge
// 					onClick={ () => {
// 						this.onAdd();
// 					}}
// 				>
// 					Add attribute
// 				</Button>
// 			</div>
// 	}
// }
