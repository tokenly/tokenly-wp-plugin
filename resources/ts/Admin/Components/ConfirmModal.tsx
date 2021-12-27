import * as React from 'react';
import { Component } from 'react';

import { 
	// @ts-ignore
	Modal,
	Flex,
	Button,
} from '@wordpress/components';

interface ConfirmModalProps {
	title: string;
	subtitle: string;
	onRequestClose: any;
	onChoice: any;
}

interface ConfirmModalState {
	keywords: string;
	user: number;
	users: Array<ComboboxOption>;
}

interface ComboboxOption {
	value: string,
	label: string,
}

export default class ConfirmModal extends Component<ConfirmModalProps, ConfirmModalState> {
	constructor( props: ConfirmModalProps ) {
		super( props );
		this.onRequestClose = this.onRequestClose.bind( this );
	}

	onRequestClose() {
		this.props.onRequestClose();
	}

	onChoice( choice: string ) {
		this.props.onChoice( choice );
	}
	
	render() {
		return (
			<Modal title={ this.props.title } onRequestClose={ this.onRequestClose }>
				<div>{ this.props.subtitle } </div>
				<Flex
					justify="flex-start"
					style={ { marginTop: '12px' } }	
				>
					<Button
						isSecondary
						onClick={ () => {
							this.onChoice( 'accept' );
						}}
					>
						Accept
					</Button>
					<Button
						isSecondary
						onClick={ () => {
							this.onChoice( 'deny' );
						}}
					>
						Deny
					</Button>
				</Flex>
			</Modal>
		);
	}
}
