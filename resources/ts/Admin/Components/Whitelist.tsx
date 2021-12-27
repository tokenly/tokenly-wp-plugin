import * as React from 'react';
import { Component } from 'react';
import { WhitelistItem } from '../../Interfaces';

import { 
	Button,
	Flex,
	TextControl,
	Dashicon,
} from '@wordpress/components';

interface WhitelistProps {
	whitelist: Array<WhitelistItem>;
	onUpdate: any;
}

interface WhitelistState {
	whitelist: Array<WhitelistItem>;
}

export default class Whitelist extends Component<WhitelistProps, WhitelistState> {
	state: WhitelistState = {
		whitelist: [],
	};
	constructor( props: WhitelistProps ) {
		super( props );
		this.onUpdate = props.onUpdate;
		this.state.whitelist = Object.assign( [], props.whitelist );
	}
	
	onUpdate( whitelist: Array<WhitelistItem> ) {
		//
	}
	
	onAdd() {
		let newState = Object.assign( {}, this.state );
		newState.whitelist[ newState.whitelist.length ] = { address: '', index: '' };
		this.setState( newState );
		this.dispatchUpdate();
	}
	
	onRemove( index: number ) {
		let newState = Object.assign( {}, this.state );
		delete newState.whitelist[ index ];
		this.setState( newState );
		this.dispatchUpdate();
	}
	
	dispatchUpdate() {
		this.onUpdate( this.state.whitelist );
	}

	render() {
		const listItems = this.state.whitelist.map( ( listItem: WhitelistItem, i: number ) => {
			return (
				<Flex style={ { alignItems: 'flex-end', margin: '8px 0' } }>
					<TextControl
						label="Contract Address"
						value={ listItem.address }
						onChange={ ( value: string ) => {
								let newState = Object.assign( {}, this.state );
								newState.whitelist[i].address = value;
								this.setState( { ...newState } );
								this.dispatchUpdate();
							}
						}
					/>
					<TextControl
						label="Token Index"
						value={ listItem.index }
						onChange={ ( value: string ) => {
								let newState = Object.assign( {}, this.state );
								newState.whitelist[ i ].index = value;
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
			)
		} );
		return (
			<div>
				<ul>{ listItems }</ul>
				<Button
					isSecondary
					isLarge
					onClick={ () => {
						this.onAdd();
					} }
				>
					Add Token
				</Button>
			</div>
		);
	}
}
