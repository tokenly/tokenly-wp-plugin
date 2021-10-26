import * as React from 'react';
import { Component } from 'react';
import { WhitelistItem } from '../../repositories/WhitelistRepository';

declare const wp: any;

const { __ } = wp.i18n;

const {
	Button,
	Flex,
	TextControl,
	Dashicon,
} = wp.components;

const Spacer = wp.components.__experimentalSpacer;

interface WhitelistProps {
	whitelist: Array<WhitelistItem>;
	onUpdate: any;
}

interface WhitelistState {
	whitelist: Array<WhitelistItem>;
}

export class Whitelist extends Component<WhitelistProps, WhitelistState> {
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
		newState.whitelist[newState.whitelist.length] = { address: '', index: '' };
		this.setState( newState );
		this.dispatchUpdate();
	}
	
	onRemove( index: number ) {
		let newState = Object.assign( {}, this.state );
		delete newState.whitelist[index];
		this.setState( newState );
		this.dispatchUpdate();
	}
	
	dispatchUpdate() {
		this.onUpdate( this.state.whitelist );
	}

	render() {
		const listItems = this.state.whitelist.map( ( listItem: WhitelistItem, i: number ) =>
		<div>
			<Flex>
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
							newState.whitelist[i].index = value;
							this.setState({ ...newState } );
							this.dispatchUpdate();
						}
					}
				/>
				<Button
					variant="secondary"
					onClick={ () => {
						this.onRemove( i );
					}}
				>
					<Dashicon icon="no" />
				</Button>
			</Flex>
			<Spacer margin={4} />
		</div>
		
	);
		return <div>
				<ul>{listItems}</ul>
				<Button
					isPrimary
					isLarge
					onClick={ () => {
						this.onAdd();
					}}
				>
					{ __( 'Add Token' ) }
				</Button>
			</div>
	}
}